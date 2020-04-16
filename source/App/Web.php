<?php

namespace Source\App;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Source\Models\Card;
use Source\Models\Field;
use Source\Models\Lot;
use Source\Models\Metadata;
use Source\Models\Model;
use Source\Models\User;

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

        $_SESSION['login']['cratedCards'] = 1;

        $this->router->redirect('web.cardCreate');
    }

    /**
     * @param $data
     */
    public function fieldsFilter($data): void
    {
        $id = key($data);
        $fields = (new Field())
            ->find(
                'model_id = :model_id', 'model_id='. $id, 'metadata_id'
            )
            ->fetch(true);

        foreach ($fields as $field){
            $metadata = (new Metadata())
                ->findById($field->metadata_id);

            // Return to ajax
            echo '$'. $metadata->name .'-'. $metadata->label_name .'-'. $metadata->description .'-'. $metadata->type;
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
        $this->loginCheck();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $metadata = new Metadata();
        $metadata->name = $data['metadataName'];
        $metadata->label_name = $data['metadataLabelName'];
        $metadata->description = $data['metadataDescription'];
        $metadata->type = $data['metadataType'];

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
        $model->created_by = $_SESSION['login']['name'];
        $model->save();

        $dataFound = array();

        foreach ($metadata as $mData){
            if (!in_array($mData->name, $dataFound)){
                $str = strpos($data['modelCode'], '$'.$mData->name);
                if($str == true){
                    $dataFound[] = $mData->name;
                    $fields = new Field();
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
    public function loginCheck(): void
    {
        if (!isset($_SESSION['login'])) {
            $this->router->redirect('web.login');
        }
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