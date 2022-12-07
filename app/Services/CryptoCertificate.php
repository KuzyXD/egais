<?php

namespace App\Services;

/**
 * Wrapper for CPCertficate object
 */
class CryptoCertificate
{
    public $Subject;
    public $Issuer;
    public $Version;
    public $SerialNumber;
    public $Thumbprint;
    public $ValidFrom;
    public $ValidTo;
    public $HasPrivate;
    public $IsValid;
    private $original;
    private $pin;

    function __construct($certificate)
    {
        $this->original = $certificate;
        $this->Subject = $this->parseDN($certificate->get_SubjectName());
        $this->Issuer = $this->parseDN($certificate->get_IssuerName());
        $this->Version = $certificate->get_Version();
        $this->SerialNumber = $certificate->get_SerialNumber();
        $this->Thumbprint = $certificate->get_Thumbprint();
        $this->ValidFrom = $certificate->get_ValidFromDate();
        $this->ValidTo = $certificate->get_ValidToDate();
        $this->HasPrivate = $certificate->HasPrivateKey();
    }

    private function parseDN($dn)
    {
        $tags = [
            'CN' => 'Name',
            'S' => 'Region',
            'ST' => 'Region',
            'STREET' => 'Address',
            'O' => 'Company',
            'OU' => 'PostType',
            'T' => 'Post',
            'TITLE' => 'Post',
            'ОГРН' => 'Ogrn',
            'OGRN' => 'Ogrn',
            'СНИЛС' => 'Snils',
            'SNILS' => 'Snils',
            'ИНН' => 'Inn',
            'INN' => 'Inn',
            'E' => 'Email',
            'G' => 'GivenName',
            'GN' => 'GivenName',
            'SN' => 'SurName',
            'L' => 'City'
        ];

        preg_match_all('/\s\w+=/u', $dn, $matches);

        $buf = $dn;
        $i = 0;

        $fields = array_reduce(array_reverse($matches[0]), function ($acc, $cur) use (&$buf, &$i, $tags) {
            //$pos = mb_strpos($buf, $cur);
            $pos = strpos($buf, $cur);

            $v = substr($buf, $pos);
            $v = str_replace($cur, '', $v);
            $v = preg_replace('/\s*"?(.*?)"?,?\s?$/', '$1', $v);
            $v = preg_replace('/""/', '"', $v);

            $tag = trim(str_replace('=', '', $cur));

            if (array_key_exists($tag, $tags)) {
                $acc[$tags[$tag]] = $v;
            }

            $buf = substr($buf, 0, $pos);

            $i++;

            return $acc;
        }, []);

        return (object)$fields;
    }

    function GetCertificate()
    {
        return $this->original;
    }

    function GetPin()
    {
        return $this->pin;
    }

    function SetPin($pin)
    {
        $this->pin = $pin;
    }

}
