<?php
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');

	require_once "Classes/PHPExcel.php";
	$objReader = new PHPExcel();

	$inputFileName = 'cadastroemlote.xlsx';
	echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);


	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	
	for($i = 3; $i <= 3; $i++){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 
		    'https://viacep.com.br/ws/'. $sheetData[$i]["N"] .'/json/'
		);
		$content = get_object_vars(json_decode(curl_exec($ch)));
		
		$atv = array_diff(str_split($sheetData[$i]["D"],7),["0000000"]);

		$date = explode("/",$sheetData[$i]["E"]);
		$date = $date[2] ."-". $date[1] ."-". $date[0];
		
		if($sheetData[$i]["H"] == "Filial"){
			$sheetData[$i]["H"] = "true";
		}else{
			$sheetData[$i]["H"] = "false";
		}

		$aux = 0;

		foreach ($atv as  $value) {
			if($aux == 0){
				$item =
'<item xsi:type="Servicos_AtividadeDto">
<cod_cnae xsi:type="xsd:string">'. $value .'</cod_cnae>
<is_atividade_principal xsi:type="xsd:string">true</is_atividade_principal>
<is_exerce_no_endereco xsi:type="xsd:string">true</is_exerce_no_endereco>
</item>';
				$aux = 1;
			}else{
				$item .=
PHP_EOL . '<item xsi:type="Servicos_AtividadeDto">
<cod_cnae xsi:type="xsd:string">'. $value .'</cod_cnae>
<is_atividade_principal xsi:type="xsd:string">false</is_atividade_principal>
<is_exerce_no_endereco xsi:type="xsd:string">false</is_exerce_no_endereco>
</item>';				
			}
		}

$text = '<env:Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope" xmlns:ns1="https://www.voxtecnologia.com.br/servicos/ws-dados-empresas" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:enc="http://www.w3.org/2003/05/soap-encoding">
<env:Body>
<ns1:dadosEmpresa env:encodingStyle="http://www.w3.org/2003/05/soap-encoding">
<mensagem xsi:type="ns1:Servicos_MensagemDto">
<controle xsi:type="ns1:Servicos_ControleDto">
<categMens xsi:type="xsd:string">dadosEmpresa</categMens>
<data xsi:type="xsd:string">2020-01-31 11:32:53</data>
<versao xsi:nil="true">2.0</versao>
<isDeferimentoPref xsi:nil="true"/>
<inscricaoEmOutraUf xsi:nil="true"/>
<hash xsi:type="xsd:string">3ae6b7a694c5d9ba5e782c4f0eb807de</hash>
</controle>
<dadosEvento xsi:type="ns1:Servicos_DadosEventoDto">
<nu_tipo_orgao_registro xsi:type="xsd:string">104306</nu_tipo_orgao_registro>
<eventos xsi:itemType="ns1:Servicos_EventoDto" xsi:type="ns1:ArrayOfServicos_EventoDto" enc:arraySize="1">
<item xsi:type="Servicos_EventoDto">
<nu_seq_evento xsi:type="xsd:int">101</nu_seq_evento>
</item>
</eventos>
<is_filial xsi:type="xsd:string">'.$sheetData[$i]["H"].'</is_filial>  
<co_matriz_cnpj xsi:type="xsd:string"/>
<contador xsi:type="Servicos_ContadorDto"/>
<empresa xsi:type="ns1:Servicos_EmpresaDto">
<ds_razao_social xsi:type="xsd:string">'. $sheetData[$i]["G"] .'</ds_razao_social>
<co_nire xsi:type="xsd:string">9999999999</co_nire>
<co_cnpj xsi:type="xsd:string">'. $sheetData[$i]["B"] .'</co_cnpj>
<ds_nome_fantasia xsi:type="xsd:string">'. $sheetData[$i]["I"] .'</ds_nome_fantasia>
<cod_natureza xsi:type="xsd:string">'. $sheetData[$i]["F"].'</cod_natureza>
<co_inscricao_estadual xsi:type="xsd:string"/>
<co_inscricao_municipal xsi:type="xsd:string"/>
<co_ddd_telefone xsi:type="xsd:string">82</co_ddd_telefone>
<co_telefone xsi:type="xsd:string">33125060</co_telefone>
<co_ddd_fax xsi:type="xsd:string">82</co_ddd_fax>
<co_fax xsi:type="xsd:string">33125060</co_fax>
<dt_inicio_atividades xsi:type="xsd:string">'. $date .'</dt_inicio_atividades>
<dt_termino_atividades xsi:type="xsd:string"></dt_termino_atividades>
<ds_objeto xsi:type="xsd:string">
Cadastramento de ofício
</ds_objeto>
<dt_assinatura_ata xsi:type="xsd:string">'. $date .'</dt_assinatura_ata>
<cod_porte xsi:type="xsd:int">1</cod_porte>
<endereco xsi:type="ns1:Servicos_EnderecoEmpresaDto">
<co_cep xsi:type="xsd:string">'. $sheetData[$i]["N"] .'</co_cep>
<nu_seq_tipo_logradouro xsi:type="xsd:int">'. $sheetData[$i]["J"] .'</nu_seq_tipo_logradouro>
<ds_endereco xsi:type="xsd:string">'. $sheetData[$i]["K"] .'</ds_endereco>
<co_numero xsi:type="xsd:string">'. $sheetData[$i]["L"] .'</co_numero>
<ds_complemento xsi:type="xsd:string"/>
<ds_bairro xsi:type="xsd:string">'. $content["bairro"] .'</ds_bairro>
<ds_email xsi:type="xsd:string">atendimento@semec.maceio.al.gov.br</ds_email>
<co_caixa_postal xsi:type="xsd:string"/>
<co_caixa_postal_cep xsi:type="xsd:string"/>
<ds_referencia xsi:nil="true"/>
<nu_nirf xsi:nil="true"/>
<nu_incra xsi:nil="true"/>
<nu_metragem xsi:nil="true">10.00</nu_metragem>
<cod_municipio xsi:type="xsd:int">270430</cod_municipio>
<nu_area_utilizada xsi:type="xsd:string">10.00</nu_area_utilizada>
<co_inscricao_imobiliaria xsi:type="xsd:string"></co_inscricao_imobiliaria>
<nu_seq_tipo_imovel xsi:type="xsd:string">1</nu_seq_tipo_imovel>
</endereco>
<co_situacao_empresa xsi:type="xsd:string">03</co_situacao_empresa>
<dt_ultimo_arquivamento xsi:type="xsd:string">'. $date .'</dt_ultimo_arquivamento>
<dt_constituicao xsi:nil="true">'. $date .'</dt_constituicao>
<co_matriz_nire xsi:nil="true"/>
<nu_capital_integralizado xsi:type="string">1000.00</nu_capital_integralizado>
<nu_destaque_capital xsi:nil="true">0.00</nu_destaque_capital>
<co_nire_anterior xsi:nil="true"/>
<responsavel_tecnico xsi:itemType="ns1:Servico_ResponsavelTecnicoDto" xsi:type="ns1:ArrayOfServico_ResponsavelTecnicoDto" enc:arraySize="0"/>
<responsavel_legal xsi:type="xsd:string">responsavel desconhecido</responsavel_legal>
<cpf_responsavel_legal xsi:type="xsd:string">84388828033</cpf_responsavel_legal>
<email_responsavel_legal xsi:type="xsd:string">atendimento@semec.maceio.al.gov.br</email_responsavel_legal>
<ddd_responsavel_legal xsi:type="xsd:string">82</ddd_responsavel_legal>
<telefone_responsavel_legal xsi:type="xsd:string">33125060</telefone_responsavel_legal>
<nu_seq_tipo_unidade xsi:type="int">0</nu_seq_tipo_unidade>
<nu_capital_social xsi:type="xsd:string">1000.00</nu_capital_social>
<ds_sitio xsi:type="xsd:string"/>
</empresa>
<atividades xsi:itemType="ns1:Servicos_AtividadeDto" xsi:type="ns1:ArrayOfServicos_AtividadeDto" enc:arraySize="10">
'. $item .'
</atividades>
<socios xsi:itemType="ns1:Servicos_SocioDto" xsi:type="ns1:ArrayOfServicos_SocioDto" enc:arraySize="0">
<item xsi:type="Servicos_SocioDto">
<ds_nome xsi:type="xsd:string">SOCIO DESCONHECIDO</ds_nome>
<cod_pais xsi:type="xsd:int">105</cod_pais>
<co_cpf_cnpj xsi:type="xsd:string">84388828033</co_cpf_cnpj>
<co_cep xsi:type="xsd:string">57160000</co_cep>
<ds_endereco xsi:type="xsd:string">PEDRO MONTEIRO</ds_endereco>
<co_numero xsi:type="xsd:string">47</co_numero>
<ds_complemento xsi:type="xsd:string"/>
<ds_bairro xsi:type="xsd:string">CENTRO</ds_bairro>
<ds_email xsi:type="xsd:string">atendimento@semec.maceio.al.gov.br</ds_email>
<ds_endereco_completo xsi:type="xsd:string"/>
<co_ddd_telefone xsi:type="xsd:string">82</co_ddd_telefone>
<co_telefone xsi:type="xsd:string">33125060</co_telefone>
<co_ddd_celular xsi:type="xsd:string"></co_ddd_celular>
<co_celular xsi:type="xsd:string"></co_celular>
<co_ddd_fax xsi:type="xsd:string"/>
<co_fax xsi:type="xsd:string"/>
<ds_estado_civil xsi:type="xsd:string">CASADO(A)</ds_estado_civil>
<dt_nascimento xsi:type="xsd:string">1983-07-05</dt_nascimento>
<co_sexo xsi:type="xsd:string">F</co_sexo>
<co_identidade xsi:type="xsd:string">111111</co_identidade>
<ds_orgao_emissor xsi:type="xsd:string">SSP</ds_orgao_emissor>
<co_uf_emissor xsi:type="xsd:string">AL</co_uf_emissor>
<dt_inicio_mandato xsi:type="xsd:string">2009-09-09</dt_inicio_mandato>
<dt_fim_mandato xsi:type="xsd:string"/>
<nu_seq_tipo_qualificacao xsi:type="xsd:int">101</nu_seq_tipo_qualificacao>
<ds_mae xsi:type="xsd:string">mae desconhecida</ds_mae>
<dt_saida_sociedade xsi:nil="true"/>
<dt_entrada_sociedade xsi:nil="true">2009-09-09</dt_entrada_sociedade>
<nu_seq_tipo_pessoa xsi:nil="true">1</nu_seq_tipo_pessoa>
<is_emancipado xsi:nil="true"/>
<motivo_emancipacao xsi:nil="true"/>
<nu_seq_tipo_documento xsi:nil="true">1</nu_seq_tipo_documento>
<ds_pai xsi:nil="true"/>
<nu_registro_cartorio xsi:nil="true"/>
<ano_registro_cartorio xsi:nil="true"/>
<nu_cartorio xsi:nil="true"/>
<ds_nome_comarca xsi:nil="true"/>
<ds_nacionalidade xsi:nil="true">BRASILEIRA</ds_nacionalidade>
<nu_seq_municipio_naturalidade xsi:nil="true">270430</nu_seq_municipio_naturalidade>
<nu_seq_uf_naturalidade xsi:nil="true"/>
<nu_seq_tipo_logradouro xsi:nil="true">33</nu_seq_tipo_logradouro>
<nu_caixa_postal xsi:nil="true"/>
<ds_regime_bens xsi:nil="true">Comunhão Parcial</ds_regime_bens>
<nu_seq_regime_bens xsi:nil="true">1</nu_seq_regime_bens>
<ds_documento_orgao_emissor xsi:nil="true"/>
<co_documento_uf_emissor xsi:nil="true"/>
<dt_documento_emissao xsi:nil="true"/>
<is_representado xsi:nil="true"/>
<representante xsi:nil="true"/>
<valor_participacao xsi:nil="true">1000.00</valor_participacao>
<porcentagem_participacao xsi:nil="true">100.0000</porcentagem_participacao>
<ds_cargo_administrador xsi:nil="true"/>
<cod_municipio xsi:type="xsd:int">270430</cod_municipio>
<representado/>
</item>
</socios>
<forma_atuacao xsi:itemType="ns1:Servicos_FormaAtuacaoDto" xsi:type="ns1:ArrayOfServicos_FormaAtuacaoDto" enc:arraySize="0">
<item xsi:type="Servicos_FormaAtuacaoDto">
<nu_seq_forma_atuacao xsi:type="xsd:int">1</nu_seq_forma_atuacao>
</item>
</forma_atuacao>
<co_protocolo_consulta_previa xsi:type="xsd:string">ALP999999999</co_protocolo_consulta_previa>
<co_protocolo_entidade_registro xsi:type="xsd:string">200000000</co_protocolo_entidade_registro>
<nu_seq_orgao_emissor xsi:type="xsd:int"/>
<solicitante xsi:type="Servicos_SolicitanteDto">
<co_cpf_cnpj xsi:type="xsd:string">84388828033</co_cpf_cnpj>
<ds_nome xsi:type="xsd:string">desconhecido</ds_nome>
<is_contador xsi:type="xsd:string">false</is_contador>
<co_ddd_telefone xsi:type="xsd:string">82</co_ddd_telefone>
<co_telefone xsi:type="xsd:string">33125060</co_telefone>
<co_ramal xsi:type="xsd:string"/>
<ds_email xsi:type="xsd:string">atendimento@semec.maceio.al.gov.br</ds_email>
</solicitante>
</dadosEvento>
</mensagem>
</ns1:dadosEmpresa>
</env:Body>
</env:Envelope>';
		
		$hour = date("His");
        $today = date("Ymd");
		$myfile = fopen("files/DEMP". $sheetData[$i]["B"] ."-". $today ."-_114740531-25196559.xml", "w");
		fwrite($myfile, $text);
		fclose($myfile);		

	}
?>