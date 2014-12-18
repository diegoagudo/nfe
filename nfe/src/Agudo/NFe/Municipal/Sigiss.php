<?php

namespace Agudo\NFe\Municipal;

/**
 * Class Sigiss
 *
 * @package agudo\NFe\Municipal
 * @Author Diego Agudo <diego@agudo.eti.br>
 *
 * 2014-11-18 v0.1
 */

class Sigiss {
    // WSDL URL
    protected $wsdl             = '';
    // Inscricao Municipal
    protected $ccm              = '';
    // CPNJ
    protected $cnpj             = '';
    // Senha de acesso
    protected $senha            = '';
    // Servico
    protected $servico          = '';
    // Codigo IBGE Municipal
    protected $codigo_municipio = '';
    // Situacao da NF
    protected $situacao         = '';
	// Ambiente
	protected $env				= 'production';
    // Params
    protected $params           = array();


    /**
     * __construct
     *
     * @param array $params
     * @throws \Exception
     */
    public function __construct($params) {
        try {
            if(!is_array($params))
                throw new \Exception('O parametro deve ser no formato array.');

            $this->params = $params;

            if ($this->env != 'production') {
                $this->wsdl = 'https://testemarilia.sigiss.com.br/testemarilia/ws/sigiss_ws.php?wsdl';
            } else {
                $this->wsdl = 'https://marilia.sigiss.com.br/marilia/ws/sigiss_ws.php?wsdl';
            }

        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * defineTomadorTipo
     *
     */
    private function defineTomadorTipo() {
        // is not CPF
        if(strlen($this->params['tomador_cnpj']) > 11) {
            // is same City
            if($this->codigo_municipio == $this->params['tomador_cod_cidade']) {
                $this->params['tomador_tipo'] = 3;
            } else {
                $this->params['tomador_tipo'] = 4;
            }
        } else {
            $this->params['tomador_tipo'] = 2;
        }
    }


    /**
     * requireFields
     *
     * @param $params
     * @throws \Exception
     */
    private function requireFields() {
        try {
            $requireFields = array('id_sis_legado', 'valor', 'base', 'tomador_tipo', 'tomador_cnpj',
                                   'tomador_email', 'descricaoNF', 'tomador_razao', 'tomador_endereco',
                                   'tomador_numero', 'tomador_bairro', 'tomador_CEP',
                                   'tomador_cod_cidade', 'tomador_fone'
            );

            foreach ($this->params as $k => $v) {
                if (in_array($k, $requireFields)) {
                    if (empty($v)) {
                        throw new \Exception("O campo $k deve ser informado");
                    }
                }
            }
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * clearEmptyFields
     *
     * @throws \Exception
     */
    private function clearEmptyFields() {
        try {
            foreach ($this->params as $k => $v) {
                if (empty($v)) {
                    unset($this->params[$k]);
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * sanitizeParams
     *
     * @throws \Exception
     */
    private function sanitizeParams() {
        try {
            if(empty($this->params))
                throw new \Exception('Nenhum parametro encontrado');

            $this->params['crc']                 = !empty($this->params['crc'])                 ? $this->params['crc']                	: "";
            $this->params['crc_estado']          = !empty($this->params['crc_estado'])          ? $this->params['crc_estado']         	: "";
            $this->params['aliquota_simples']    = !empty($this->params['aliquota_simples'])    ? $this->params['aliquota_simples']   	: "";
            $this->params['id_sis_legado']       = !empty($this->params['id_sis_legado'])       ? $this->params['id_sis_legado']      	: "";
            $this->params['valor']               = !empty($this->params['valor'])               ? $this->params['valor']				: "";
            $this->params['base']                = !empty($this->params['base'])                ? $this->params['base']					: "";
            $this->params['descricaoNF']         = !empty($this->params['descricaoNF'])         ? $this->params['descricaoNF']       	: "";
            $this->params['tomador_tipo']        = !empty($this->params['tomador_tipo'])        ? $this->params['tomador_tipo']       	: "";
            $this->params['tomador_cnpj']        = !empty($this->params['tomador_cnpj'])        ? $this->params['tomador_cnpj']			: "";
            $this->params['tomador_email']       = !empty($this->params['tomador_email'])       ? $this->params['tomador_email']      	: "";
            $this->params['tomador_ie']          = !empty($this->params['tomador_ie'])          ? $this->params['tomador_ie']         	: "";
            $this->params['tomador_im']          = !empty($this->params['tomador_im'])          ? $this->params['tomador_im']         	: "";
            $this->params['tomador_razao']       = !empty($this->params['tomador_razao'])       ? $this->params['tomador_razao']      	: "";
            $this->params['tomador_fantasia']    = !empty($this->params['tomador_fantasia'])    ? $this->params['tomador_fantasia']   	: "";
            $this->params['tomador_endereco']    = !empty($this->params['tomador_endereco'])    ? $this->params['tomador_endereco']   	: "";
            $this->params['tomador_numero']      = !empty($this->params['tomador_numero'])      ? $this->params['tomador_numero']     	: "";
            $this->params['tomador_complemento'] = !empty($this->params['tomador_complemento']) ? $this->params['tomador_complemento']	: "";
            $this->params['tomador_bairro']      = !empty($this->params['tomador_bairro'])      ? $this->params['tomador_bairro']     	: "";
            $this->params['tomador_cep']         = !empty($this->params['tomador_cep'])         ? $this->params['tomador_cep']        	: "";
            $this->params['tomador_cod_cidade']  = !empty($this->params['tomador_cod_cidade'])  ? $this->params['tomador_cod_cidade'] 	: "";
            $this->params['tomador_fone']        = !empty($this->params['tomador_fone'])        ? $this->params['tomador_fone']       	: "";
            $this->params['tomador_ramal']       = !empty($this->params['tomador_ramal'])       ? $this->params['tomador_ramal']      	: "";
            $this->params['tomador_fax']         = !empty($this->params['tomador_fax'])         ? $this->params['tomador_fax']        	: "";
            $this->params['rps_num']             = !empty($this->params['rps_num'])             ? $this->params['rps_num']            	: "";
            $this->params['rps_serie']           = !empty($this->params['rps_serie'])           ? $this->params['rps_serie']          	: "";
            $this->params['rps_dia']             = !empty($this->params['rps_dia'])             ? $this->params['rps_dia']            	: "";
            $this->params['rps_mes']             = !empty($this->params['rps_mes'])             ? $this->params['rps_mes']            	: "";
            $this->params['rps_ano']             = !empty($this->params['rps_ano'])             ? $this->params['rps_ano']            	: "";
            $this->params['outro_municipio']     = !empty($this->params['outro_municipio'])     ? $this->params['outro_municipio']    	: "";
            $this->params['cod_outro_municipio'] = !empty($this->params['cod_outro_municipio']) ? $this->params['cod_outro_municipio']	: "";
            $this->params['retencao_iss']        = !empty($this->params['retencao_iss'])        ? $this->params['retencao_iss']       	: "";
            $this->params['pis']                 = !empty($this->params['pis'])                 ? $this->params['pis']                	: "";
            $this->params['cofins']              = !empty($this->params['cofins'])              ? $this->params['cofins']             	: "";
            $this->params['inss']                = !empty($this->params['inss'])                ? $this->params['inss']               	: "";
            $this->params['irrf']                = !empty($this->params['irrf'])                ? $this->params['irrf']               	: "";
            $this->params['csll']                = !empty($this->params['csll'])                ? $this->params['csll']               	: "";

            // Set Tomador Tipo
            $this->defineTomadorTipo();

            // Check require fields
            $this->requireFields();

            // Cleaning empty fields
            $this->clearEmptyFields();

        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * send
     *
     * @throws \Exception
     */
    public function send() {
        try {
            if(empty($this->params))
                throw new \Exception('Nenhum parametro encontrado');

            // Sanitize Params
            $this->sanitizeParams();

            // setting Up data access
            $this->params['ccm']      = $this->ccm;
            $this->params['cnpj']     = $this->cnpj;
            $this->params['senha']    = $this->senha;
            $this->params['servico']  = $this->servico;
            $this->params['situacao'] = $this->situacao;

			// NuSOAP
            $nusoap       = new \nusoap_client($this->wsdl, true);
            $result       = $nusoap->call('GerarNota', array('DescricaoRps' => $this->params));

            $escrituracao = $result['RetornoNota']['Resultado'];
            $numero_nf	  = $result['RetornoNota']['Nota'];
            $url_nf_pdf   = $result['RetornoNota']['LinkImpressao'];

            $erro = null;
            if(substr(file_get_contents($url_nf_pdf),0,4) != '%PDF') {
                $erro = array('msg'=>'ERRO', 'conteudo'=> serialize($this->params));
            } else {
                $erro = array('msg'=>'OK');
            }

            return array('url_nf_pdf'=>$url_nf_pdf, 'erro'=>$erro);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}