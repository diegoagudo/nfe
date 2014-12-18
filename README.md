## NFe Municipal

Classe de integração de NFe Municipais que utilizam o sistema SIGISS

## Exemplos

Geração de NFe:
```php
$params = array(
		'valor'                        => 1.25,
		'base'                         => 1.25,
		'tomador_cnpj'                 => 'CNPJ',
		'tomador_ie'                   => 'Inscricao estadual',
		'tomador_email'                => 'email@do.tomador',
		'descricaoNF'                  => 'Descricao da NFe',
		'tomador_razao'                => 'Razao social',
		'tomador_fantasia'             => 'Nome Fantasia',
		'tomador_endereco'             => 'Endereco',
		'tomador_numero'               => 'Numero',
		'tomador_complemento'          => 'Complemento',
		'tomador_bairro'               => 'Bairro',
		'tomador_CEP'                  => 'CEP',
		'tomador_cod_cidade'           => 'Codigo do municipal da tabela do IBGE',
		'tomador_fone'                 => 'Telefone',
		'id_sis_legado'                => 'Codigo sequencial do seu sistema (Opcional)',
);


/**
 * Geracao/Envio da NFe
 */
$nfeMunicipalSigiss = new \Agudo\NFe\Municipal\Sigiss($params);
$retorno            = $nfeMunicipalSigiss->send();

```



## Instalação

Atualizar manualmente `composer.json` com:

```json
{
  "require": {
    "agudo/nfe": "*"
  }
}
```

Ou simplesmente usar o seu terminal: `composer require agudo/nfe:*` :8ball:

```php
use Agudo\NFe\Municipal\Sigiss as Sigiss;
```

## License

NFe é liberado sob a [MIT License](http://www.opensource.org/licenses/MIT).
