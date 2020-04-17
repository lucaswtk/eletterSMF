<?php

namespace Source\App;

use CoffeeCode\Router\Router;
use Dompdf\Dompdf;
use http\Exception\InvalidArgumentException;
use League\Plates\Engine;
use Source\Models\Card;
use Source\Models\CardFields;
use Source\Models\MetadataFields;
use Source\Models\Lot;
use Source\Models\Metadata;
use Source\Models\Model;
use Source\Models\User;
use ZipArchive;

/**
 * Class Web
 *
 * @package Source\App
 */
class Web
{
	/**
	 * @var Router
	 */
	private $router;

	/**
	 * @var Engine
	 */
	private $view;

	/**
	 * Web constructor.
	 */
	public function __construct($router)
	{
		$this->router = $router;
		$this->view = Engine::create(THEMES, 'php');
		$this->view->addData([
			'router' => $router,
		]);

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
	}

	/**
	 * @return void
	 */
	public function login(): void
	{
		if (!empty($_SESSION['login'])) {
			$this->router->redirect('web.home');
		}

		echo $this->view->render('login', [
			'title' => 'Login | ' . SITE,
		]);
	}

	/**
	 * @return void
	 */
	public function logout(): void
	{
		if (!empty($_SESSION['login'])) {
			unset($_SESSION['login']);
		}

		$this->router->redirect('web.login');
	}

	/**
	 * @param array $data
	 * @return void
	 */
	public function validateLogin(array $data): void
	{
		$data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

		$users = (new User())
			->find(
				'registration = :registration AND password = :password AND organ = :organ',
				'registration=' . $data['registration'] . '&password=' . $data['password'] . '&organ=' . $data['organ'],
				'id, name, registration'
			)
			->fetch();

		if (!$users) {
			echo 'Usuário não encontrado';
			exit;
		}

		$_SESSION['login'] = [
			'id' => $users->id,
			'name' => $users->name,
			'registration' => $users->registration,
		];

		$this->router->redirect('web.home');
	}

	/**
	 * @return void
	 */
	public function home(): void
	{
        $this->loginCheck();

		echo $this->view->render('home', [
			'title' => 'Home | ' . SITE,
			'name' => explode(' ', $_SESSION['login']['name'])[0],
		]);
	}

    /**
     *
     */
    public function cardCreate(): void
    {
        $this->loginCheck();

        $models = (new Model())->find()->fetch(true);

        echo $this->view->render('cardCreate', [
            'title' => 'Cadastrar Carta | ' . SITE,
            'models' => $models
        ]);
    }

    /**
     * @param $data
     */
    public function validateCard($data): void
    {
        $this->loginCheck();

        $card = new Card();
        $lot = new Lot();
        $lotId = $lot->find()->fetch(true);

        if($lotId == null){
            $lot->id = 1;
            $lot->save();
            $idLot = $lot->id;
        }else{
            $id = count($lotId)-1;
            if($lotId[$id]->status == 1){
                $lot->id = $lotId[$id]->id + 1;
                $lot->save();
                $idLot = $lot->id;
            }else{
                $idLot = $id + 1;
            }
        }

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $card->card_lot = $idLot;
        $card->model_id = $data['modelId'];
        $card->created_by = $_SESSION['login']['registration'];
        $card->receiver_name = $data['receiverName'];
        $card->receiver_street = $data['receiverStreet'];
        $card->receiver_city = $data['receiverCity'];
        $card->receiver_state = $data['receiverState'];
        $card->receiver_postcode = $data['receiverPostcode'];
        $card->receiver_neighborhood = $data['receiverNeighborhood'];
        $card->receiver_number_address = $data['receiverNumberAddress'];
        $card->receiver_complement = $data['receiverComplement'];
        $card->save();

        unset(
            $data['receiverName'],
            $data['receiverStreet'],
            $data['receiverNumberAddress'],
            $data['receiverPostcode'],
            $data['receiverCity'],
            $data['receiverNeighborhood'],
            $data['receiverComplement'],
            $data['receiverState']
        );

        foreach($data as $key => $value){
            $cardFields = new CardFields();
            $cardFields->id_card = $card->id;
            $cardFields->name_metadata = $key;
            $cardFields->value = $value;
            $cardFields->save();
        }

        $_SESSION['login']['cratedCards'] = 1;

        $this->router->redirect('web.cardCreate');
    }

    /**
     * @param $data
     */
    public function fieldsFilter($data): void
    {
        $id = key($data);
        $fields = (new MetadataFields())
            ->find(
                'model_id = :model_id', 'model_id='. $id, 'metadata_id'
            )
            ->fetch(true);

        foreach ($fields as $field){
            $metadata = (new Metadata())
                ->findById($field->metadata_id);

            // Return to ajax
            echo '$'. $metadata->name .'-'. $metadata->label_name .'-'. $metadata->description .'-'. $metadata->type .'-'. $metadata->required .'-'. $id;
        }
    }

    /**
     *
     */
    public function metadataCreate(): void
    {
        if (!isset($_SESSION['login'])) {
            $this->router->redirect('web.login');
        }

        echo $this->view->render('metadataCreate', [
            'title' => 'Cadastrar Metadados | ' . SITE
        ]);
    }

    /**
     * @param $data
     */
    public function validateMetadata($data): void
    {
        if(isset($data['requiredCheck'])){
            $requiredValue = 1;
        }else{
            $requiredValue = 0;
        }
        $this->loginCheck();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $metadata = new Metadata();
        $metadata->name = $data['metadataName'];
        $metadata->label_name = $data['metadataLabelName'];
        $metadata->description = $data['metadataDescription'];
        $metadata->type = $data['metadataType'];
        $metadata->required = $requiredValue    ;

        $metadata->save();

        $_SESSION['login']['cratedMetadata'] = 1;

        $this->router->redirect('web.metadataCreate');
    }

    /**
     *
     */
    public function modelCreate(): void
    {
        if (!isset($_SESSION['login'])) {
            $this->router->redirect('web.login');
        }

        $metadata = (new Metadata())->find()->fetch(true);

        echo $this->view->render('modelCreate',[
            'title' => 'Cadastrar Modelo | ' . SITE,
            'metadata' => $metadata
        ]);
    }

    /**
     * @param $data
     */
    public function validateModel($data): void
    {
        $this->loginCheck();

        $model = new Model();
        $metadata = (new Metadata())->find()->fetch(true);
        $dataModelName = lcfirst($data['modelName']);
        $dataModelName = ucwords($dataModelName);
        $localName = str_replace(' ', '', $dataModelName);
        $localName = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/", "/(ç)/", "/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"), $localName);
        $localName = lcfirst($localName);
        $directory = FILES . "/" . $localName;

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $fileCode = ''. $data['modelCode'];
        $htmlFile = fopen($directory . "/". $localName . ".html", "w");

        fwrite($htmlFile, $fileCode);
        fclose($htmlFile);

        $countfiles = count($_FILES['modelImages']['name']);
        for($i=0; $i<$countfiles; $i++){
            $filename = $_FILES['modelImages']['name'][$i];
            move_uploaded_file($_FILES['modelImages']['tmp_name'][$i],$directory. "/" .$filename);
        }

        $model->name = $data['modelName'];
        $model->local_name = $localName;
        $model->created_by = $_SESSION['login']['registration'];
        $model->save();

        $dataFound = array();

        foreach ($metadata as $mData){
            if (!in_array($mData->name, $dataFound)){
                $str = strpos($data['modelCode'], '$'.$mData->name);
                if($str == true){
                    $dataFound[] = $mData->name;
                    $fields = new MetadataFields();
                    $fields->model_id = $model->id;
                    $fields->metadata_id = $mData->id;
                    $fields->save();
                }
            }
        }

        $_SESSION['login']['cratedModel'] = 1;

        $this->router->redirect('web.modelCreate');
    }

    /**
     *
     */
    public function lotSend(): void
    {
        $directory = TEMP;
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $lot = new Lot();
        $lotId = $lot->find()->fetch(true);
        $idLot = count($lotId);

        $cards = (new Card())
            ->find(
                'card_lot = :cardLot', 'cardLot='. $idLot
            )
            ->fetch(true);

        $aux = 0;

        foreach ($cards as $card){
            $aux++;
            $model = (new Model())
            ->find(
                'id = :modelId', 'modelId='. $card->model_id, 'local_name'
            )
            ->fetch(true);
            $localFileName = $model[0]->local_name;

            $text = '' . file_get_contents(FILES . $localFileName . '/' . $localFileName . '.html');

            $cardFields = (new CardFields())->find('id_card = :idCard', 'idCard='. $card->id)->fetch(true);

            $localImage = __DIR__."/../../background1.jpg";
            copy(FILES . $localFileName . '/background1.jpg', $localImage);

            foreach ($cardFields as $data){
                $name = "$". $data->name_metadata;
                $text = str_replace($name, $data->value, $text);
            }

            $fileToSendName = "e-Carta_XXXXX_". $idLot . "_". $aux;

            if (!file_exists($fileToSendName) && !is_dir($fileToSendName)) {
                mkdir($fileToSendName, 0777);
            }

            $dompdf = new Dompdf();
            try {
                $dompdf->set_paper("A4");
                $dompdf->load_html($text);
                $dompdf->render();
                $output = $dompdf->output();
                file_put_contents($fileToSendName . '/'. $fileToSendName .'.pdf', $output);
            } catch (MpdfException $e) {
                $error = $e->getCode();
                var_dump($error);
                exit();
            }

            shell_exec("cd ../../ & pdftops source/temp/". $fileToSendName ."/". $fileToSendName.".pdf");

            $zip = new ZipArchive();

            $zipName = "e-Carta_XXXXX_". $idLot . "_".$aux;
            if ($zip->open($zipName . '.zip', ZipArchive::CREATE)) {
                $dir = opendir($fileToSendName);
                while ($archive = readdir($dir)) {
                    if (is_file($fileToSendName .'/'. $archive)) {
                        $zip->addFile($fileToSendName .'/'. $archive);
                    }
                }
                $zip->close();
            }

            if (file_exists($zipName . '.zip')) {
                rename($zipName . '.zip', $directory .'/'. $zipName . '.zip');
            }

            $this->deleteDir($fileToSendName);

        }
        unlink($localImage);
        $this->router->redirect('web.home');
    }

    /**
     *
     */
    public function loginCheck(): void
    {
        if (!isset($_SESSION['login'])) {
            $this->router->redirect('web.login');
        }
    }

    /**
     * @param $dirPath
     */
    public static function deleteDir($dirPath): void
    {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

	/**
	 * @param array $data
	 * @return void
	 */
	public function error(array $data): void
	{
		echo $this->view->render('error', [
			'title' => "Erro {$data['errcode']}| " . SITE,
			'error' => $data['errcode'],
		]);
	}
}