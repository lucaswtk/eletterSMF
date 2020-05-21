<?php

namespace Source\App;

use CoffeeCode\Router\Router;
use Dompdf\Dompdf;
use League\Plates\Engine;
use Source\Models\Card;
use Source\Models\CardFields;
use Source\Models\Email;
use Source\Models\MetadataFields;
use Source\Models\Lot;
use Source\Models\Metadata;
use Source\Models\Model;
use Source\Models\User;
use ZipArchive;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
     * @param array $data
     * @return void
     */
    public function validateLogin(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $users = (new User())
            ->find(
                'status = 1 AND registration = :registration AND password = :password AND organ = :organ',
                'registration=' . $data['registration'] . '&password=' . md5($data['password']) . '&organ=' . $data['organ'],
                'id, name, registration'
            )
            ->fetch();

        if (!$users) {
            $this->router->redirect('web.login');
        }

        $_SESSION['login'] = [
            'id' => $users->id,
            'name' => $users->name,
            'registration' => $users->registration,
        ];

        $this->router->redirect('web.home');
    }

    /**
     *
     */
    public function accountCreate(): void
    {
        if (!empty($_SESSION['login'])) {
            $this->router->redirect('web.home');
        }

        echo $this->view->render('accountCreate', [
            'title' => 'Cadastro | ' . SITE,
        ]);
    }

    /**
     * @param $data
     */
    public function validateAccount($data): void
    {
        $password = md5($data['password']);

        $user = new User();
        $user->name = $data['name'];
        $user->registration = $data['registration'];
        $user->password = $password;
        $user->organ = $data['organ'];
        $user->email = $data['email'];
        $user->save();

        $this->router->redirect('web.login');
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
    public function dashboard(): void
    {
        $this->loginCheck();

        $user = (new User())
            ->find('status = 0')
            ->fetch(true);

        echo $this->view->render('dashboard', [
            'title' => 'Dashboard | ' . SITE,
            'accounts' => $user
        ]);
    }

    /**
     * @param $data
     */
    public function confirmAccount($data)
    {
        $email = new Email();
        $email->add(
            "Atualização no status de cadastro Eletter",
            "<p>Sua conta no Eletter foi confirmada. Agora você já tem acesso aos diversos recursos disponíveis em nosso sistema. <br>
                    Acesse: http://semecmaceio.com/eletter/</p>
                    <div> <img style='width: 20%' src='http://semecmaceio.com/eletter//themes/assets/img/person.png'> </div>
                    <p>Caso esse email seja um engano, acesse o link http://semecmaceio.com/eletter/att/". md5($data['id']) ."</p>",
            $data['name'],
            $data['email']
        )->send();

        if(!$email->error()){
            $user = (new User())->findById($data['id']);
            $user->status = 1;
            $user->save();

            echo "Sucesso! O usuário " . explode(' ', $data['name'])[0] . " teve seu cadastro confirmado.";
        }else{
            var_dump($email->error()->getMessage());
        }
    }

    /**
     * @param $data
     */
    public function removeAccount($data)
    {
        $email = new Email();
        $email->add(
            "Atualização no status de cadastro Eletter",
            "<p>Sua conta no Eletter foi negada. Tente novamente mais tarde ou entre em contato com algum de nossos administradores.</p>
                    <div> <img style='width: 20%' src='http://semecmaceio.com/eletter//themes/assets/img/person.png'> </div>",
            $data['name'],
            $data['email']
        )->send();

        if(!$email->error()){
            $user = (new User())->findById($data['id']);
            $user->destroy();

            echo "Sucesso! O usuário " . explode(' ', $data['name'])[0] . " teve seu cadastro negado.";
        }else{
            var_dump($email->error()->getMessage());
        }
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

    public function cardList(): void
    {
        $this->loginCheck();

        $cards = (new Card())
            ->find('created_by = :registration', 'registration= '. $_SESSION["login"]["registration"])
            ->fetch(true);

        $model = (new Model())->find()->fetch(true);

        echo $this->view->render('cardList', [
            'title' => 'Cartas cadastradas | ' . SITE,
            'cards' => $cards,
            'models' => $model
        ]);
    }

    public function cardShare($data): void
    {
        $cards = (new Card())->find()->fetch(true);
        foreach ($cards as $card){
            if($data['id'] == md5($card->id) && $data['user'] == md5($card->created_by)){
                $card->share = $data['id'];
                $card->save();
                echo ROOT."/cardList/". $data['id'];
            }
        }
    }

    public function openFile(array $data): void
    {
        $aux = 0;
        $cards = (new Card())->find()->fetch(true);
        $models = (new Model())->find()->fetch(true);
        $cardFields = (new CardFields())->find()->fetch(true);
        foreach ($cards as $card){
            if($card->share == $data['file']){
                $aux = 1;
                foreach ($models as $model){
                    if($model->id == $card->model_id){
                        echo file_get_contents(FILES . $model->local_name . '/' . $model->local_name . '.html');
                    }
                }
            }
        }

        if($aux == 0){
            $this->router->redirect('web.login');
        }
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

        if ($lotId == null) {
            $lot->save();
            $idLot = $lot->id;
        } else {
            $id = count($lotId) - 1;
            if ($lotId[$id]->status == 1) {
                $lot->save();
                $idLot = $lot->id;
            } else {
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
            $data['receiverState'],
            $data['modelId']
        );

        foreach ($data as $key => $value) {
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
                'model_id = :model_id', 'model_id=' . $id, 'metadata_id'
            )
            ->fetch(true);

        foreach ($fields as $field) {
            $metadata = (new Metadata())
                ->findById($field->metadata_id);

            // Return to ajax
            echo '$' . $metadata->name . '-' . $metadata->label_name . '-' . $metadata->description . '-' . $metadata->type . '-' . $metadata->required . '-' . $id;
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
        if (isset($data['requiredCheck'])) {
            $requiredValue = 1;
        } else {
            $requiredValue = 0;
        }
        $this->loginCheck();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $metadata = new Metadata();
        $metadata->name = $data['metadataName'];
        $metadata->label_name = $data['metadataLabelName'];
        $metadata->description = $data['metadataDescription'];
        $metadata->type = $data['metadataType'];
        $metadata->required = $requiredValue;

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

        echo $this->view->render('modelCreate', [
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
        $dataLocalName = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a a e e i i o o u u n n c c"), $data['modelName']);
        $localName = strtolower($dataLocalName);
        $localName = ucwords($localName);
        $localName = str_replace(' ', '', $localName);
        $localName = lcfirst($localName);
        $directory = FILES . "/" . $localName;

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $fileCode = '' . $data['modelCode'];
        $htmlFile = fopen($directory . "/" . $localName . ".html", "w");

        fwrite($htmlFile, $fileCode);
        fclose($htmlFile);

        $countfiles = count($_FILES['modelImages']['name']);
        for ($i = 0; $i < $countfiles; $i++) {
            $filename = $_FILES['modelImages']['name'][$i];
            move_uploaded_file($_FILES['modelImages']['tmp_name'][$i], $directory . "/" . $filename);
        }

        $model->name = $data['modelName'];
        $model->local_name = $localName;
        $model->created_by = $_SESSION['login']['registration'];
        $model->save();

        $dataFound = array();

        foreach ($metadata as $mData) {
            if (!in_array($mData->name, $dataFound)) {
                $str = strpos($data['modelCode'], '$' . $mData->name);
                if ($str == true) {
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

        if ($lotId == NULL) {
            $this->router->redirect('web.home');
        }

        $idLot = count($lotId);

        if ($lotId[$idLot - 1]->status == 1) {
            $_SESSION['login']['lotSend'] = 2;
            $this->router->redirect('web.home');
        }

        $cards = (new Card())
            ->find(
                'card_lot = :cardLot', 'cardLot=' . $idLot
            )
            ->fetch(true);

        $aux = 0;

        foreach ($cards as $card) {
            $aux++;
            $model = (new Model())
                ->find(
                    'id = :modelId', 'modelId=' . $card->model_id, 'local_name'
                )
                ->fetch(true);
            $localFileName = $model[0]->local_name;

            $text = '' . file_get_contents(FILES . $localFileName . '/' . $localFileName . '.html');

            $cardFields = (new CardFields())->find('id_card = :idCard', 'idCard=' . $card->id)->fetch(true);

            $localImage = __DIR__ . "/../../background1.jpg";
            copy(FILES . $localFileName . '/background1.jpg', $localImage);

            foreach ($cardFields as $data) {
                $name = "$" . $data->name_metadata;
                $text = str_replace($name, $data->value, $text);
            }

            $fileToSendName = "e-Carta_XXXXX_" . $idLot . "_" . $aux;

            if (!file_exists($fileToSendName) && !is_dir($fileToSendName)) {
                mkdir($fileToSendName, 0777);
            }

            $dompdf = new Dompdf();
            try {
                $dompdf->set_paper("A4");
                $dompdf->load_html($text);
                $dompdf->render();
                $output = $dompdf->output();
                file_put_contents($fileToSendName . '/' . $fileToSendName . '_Spool.pdf', $output);
            } catch (MpdfException $e) {
                $error = $e->getCode();
                var_dump($error);
                exit();
            }

            $output = shell_exec('cd ' . $fileToSendName . ' && pdf2ps ' . $fileToSendName . '_Spool.pdf');
            unlink($fileToSendName . '/' . $fileToSendName . '_Spool.pdf');

            $txtName = $fileToSendName . "_serviço.txt";

            $clientObjectCode = str_pad($card->id, 6, "0", STR_PAD_LEFT);

            $txtFile = (
                "Nome Destinatário: " . $card->receiver_name . "\n" .
                "Endereço Destinatário: " . $card->receiver_street . "\n" .
                "Cidade Destinatário: " . $card->receiver_city . "\n" .
                "UF Destinatário: " . $card->receiver_state . "\n" .
                "CEP Destinatáro: " . $card->receiver_postcode . "\n" .
                "Código do Objeto Cliente: 21E279" . $clientObjectCode . "\n" .
                "Número do Lote: " . $idLot . "\n" .
                "Bairo Destinatário: " . $card->receiver_neighborhood . "\n" .
                "Número do Endereço Destinatário: " . $card->receiver_number_address . "\n" .
                "Complemento Endereço Destinatário: " . $card->receiver_complement . "\n" .
                "Cartão de Postagem: 0074153541" . "\n" .
                "Número do Contrato: 9912311650" . "\n" .
                "Arquivo Complementar: " . "\n" .
                "Serviço Adicional: " . "\n" .
                "Ident. Spool: S" . "\n" .
                "Nome Arquivo Spool: " . $fileToSendName . ".ps" . "\n" .
                "Indicador Arq. Complementar: N"
            );

            $service = fopen("{$fileToSendName}/{$txtName}", 'w');
            fwrite($service, $txtFile);
            fclose($service);

            $zip = new ZipArchive();

            $zipName = "e-Carta_XXXXX_" . $idLot . "_" . $aux;
            if ($zip->open($zipName . '.zip', ZipArchive::CREATE)) {
                $dir = opendir($fileToSendName);
                while ($archive = readdir($dir)) {
                    if (is_file($fileToSendName . '/' . $archive)) {
                        $zip->addFile($fileToSendName . '/' . $archive);
                    }
                }
                $zip->close();
            }

            if (file_exists($zipName . '.zip')) {
                rename($zipName . '.zip', $directory . '/' . $zipName . '.zip');
            }

            $this->deleteDir($fileToSendName);

        }
        unlink($localImage);

        $lotUpdate = (new Lot())
            ->find(
                'id = :lotId', 'lotId=' . $idLot, 'id, status, created_at'
            )
            ->fetch();

        $lotUpdate->status = 1;
        $lotUpdate->save();

        $_SESSION['login']['lotSend'] = 1;
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
        if (!is_dir($dirPath)) {
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