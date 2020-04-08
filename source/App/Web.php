<?php

namespace Source\App;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Source\Models\Field;
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
		$this->view = Engine::create(THEMES, "php");
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

		echo $this->view->render("login", [
			"title" => "Login | " . SITE,
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
		if (empty($_SESSION['login'])) {
			$this->router->redirect('web.login');
		}

		echo $this->view->render("home", [
			"title" => "Home | " . SITE,
			'name' => explode(' ', $_SESSION['login']['name'])[0],
		]);
	}

	public function cardCreate(): void
    {
        if (!isset($_SESSION['login'])) {
            $this->router->redirect('web.login');
        }

        $models = (new Model())->find()->fetch(true);

        echo $this->view->render("cardCreate", [
            "title" => "Cadastrar Carta | " . SITE,
            "models" => $models
        ]);
    }

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

            echo "$". $metadata->name ."-". $metadata->label_name ."-" . $metadata->description ."-". $metadata->type;
        }
    }

    public function metadataCreate(): void
    {
        if (!isset($_SESSION['login'])) {
            $this->router->redirect('web.login');
        }

        echo $this->view->render("metadataCreate", [
            "title" => "Cadastrar Metadados | " . SITE
        ]);
    }

    public function validateMetadata($data): void
    {
        if (!isset($_SESSION['login'])) {
            $this->router->redirect('web.login');
        }

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $metadata = new Metadata();
        $metadata->name = $data['metadataName'];
        $metadata->label_name = $data['metadataLabelName'];
        $metadata->description = $data['metadataDescription'];
        $metadata->type = $data['metadataType'];

        $metadata->save();

        $this->router->redirect('web.metadataCreate');
    }

    public function modelCreate(): void
    {
        if (!isset($_SESSION['login'])) {
            $this->router->redirect('web.login');
        }

        $metadata = (new Metadata())->find()->fetch(true);

        echo $this->view->render("modelCreate",[
            "title" => "Cadastrar Modelo | " . SITE,
            "metadata" => $metadata
        ]);
    }

    public function validateModel($data): void
    {
        if (!isset($_SESSION['login'])) {
            $this->router->redirect('web.login');
        }

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $model = new Model();
        $metadata = (new Metadata())->find()->fetch(true);

        $localName = str_replace(" ", "", $data['modelName']);
        $localName = strtolower($localName);

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

        $this->router->redirect('web.modelCreate');
    }

	/**
	 * @param array $data
	 * @return void
	 */
	public function error(array $data): void
	{
		echo $this->view->render("error", [
			"title" => "Erro {$data["errcode"]}| " . SITE,
			"error" => $data["errcode"],
		]);
	}
}