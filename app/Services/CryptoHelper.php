<?php

namespace App\Services;

/**
 * Crypto Helper class
 */
class CryptoHelper
{
    const SIGN_DETACHED = true;
    const CADESCOM_CADES_BES = 1;
    const CAPICOM_ENCODE_BASE64 = 0;

    /**
     * Get valid certificates from store
     * @param search - filter by subject name
     * @param integer $location - https://docs.microsoft.com/ru-ru/windows/win32/seccrypto/capicom-store-location
     * @param string $store
     * @return CryptoCertificate[]
     */
    public function GetCertificates($search = null, $location = null, $store = null)
    {
        $store = $this->getStore($location, $store);
        $certs = $store->get_Certificates();
        if ($search) {
            $certs = $certs->Find(CERTIFICATE_FIND_SHA1_HASH, $search, 0);
        } else {
            $certs = $certs->Find(CERTIFICATE_FIND_TIME_VALID, date('YmdHis'), 0);
        }
        $certsArr = [];
        for ($i = 1; $i <= $certs->Count(); $i++) {
            $cert = new CryptoCertificate($certs->Item($i));
            array_push($certsArr, $cert);
        }
        return $certsArr;
    }

    /**
     * Create and open store
     *
     * @param integer $location
     * @param string $name
     * @param integer $mode
     * @return CPStore
     */
    private function getStore($location = null, $name = null, $mode = null)
    {
        $location = $location ?: CURRENT_USER_STORE;
        $name = $name ?: 'My';
        $mode = $mode ?: STORE_OPEN_READ_ONLY;

        $store = new \CPStore();
        $store->Open($location, $name, $mode);
        return $store;
    }

    /**
     * Sign file by chosen certificate
     *
     * @param CryptoCertificate $certificate
     * @param string $data
     * @param string $signFilePath
     * @return string|boolean
     */
    public function SignFile($certificate, $data, $signFilePath = null)
    {
        //$data = file_get_contents($dataFilePath);
        $sign = $this->Sign($certificate, $data, false);

        if ($signFilePath) {
            file_put_contents($signFilePath, $sign);
        }

        return $sign;
    }

    /**
     * Sign string data type by chosen certificate
     *
     * @param CryptoCertificate $certificate
     * @param string $data
     * @param boolean $toBase64
     * @return string|boolean
     */
    public function Sign($certificate, $data, $toBase64 = true)
    {
        $signer = new \CPSigner();
        $signer->set_Certificate($certificate->GetCertificate());
        $signer->set_Options(CERTIFICATE_INCLUDE_WHOLE_CHAIN);
        $signer->set_TSAAddress("http://ocsp.iecp.ru/tsp");

        if ($certificate->GetPin()) {
            $signer->set_KeyPin($certificate->GetPin());
        }

        $signedData = new \CPSignedData();
        $signedData->set_ContentEncoding(BASE64_TO_BINARY);
        $signedData->set_Content($toBase64 ? base64_encode($data) : $data);

        try {
            $signedMessage = $signedData->SignCades($signer, self::CADESCOM_CADES_BES, self::SIGN_DETACHED, self::CAPICOM_ENCODE_BASE64);
            return trim(preg_replace("/[\r\n]/", "", $signedMessage));
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Sign file by chosen certificate
     *
     * @param CryptoCertificate $certificate
     * @param string $data
     * @param string $signFilePath
     * @return string|boolean
     */
    public function SignFileAndGetB64($certificate, $data, $signFilePath = null)
    {
        //$data = file_get_contents($dataFilePath);
        $sign = $this->Sign($certificate, $data);

        if ($signFilePath) {
            file_put_contents($signFilePath, $sign);
        }

        return $sign;
    }

    /**
     * Verify file sign
     *
     * @param string $dataFilePath
     * @param string $signFilePath
     * @return array|boolean
     */
    public function VerifyFile($dataFilePath, $signFilePath)
    {
        $data = file_get_contents($dataFilePath);
        $sign = file_get_contents($signFilePath);
        return $this->Verify($data, $sign, true);
    }

    /**
     * Verify data sign
     *
     * @param string $data
     * @param string $sign
     * @param boolean $toBase64
     * @return array|boolean
     */
    public function Verify($data, $sign, $toBase64 = true)
    {
        $signedData = new \CPSignedData();
        $signedData->set_ContentEncoding(BASE64_TO_BINARY);
        $signedData->set_Content($toBase64 ? base64_encode($data) : $data);

        try {
            $signedData->VerifyCades($sign, CADES_BES, self::SIGN_DETACHED);
            $signers = $signedData->get_Signers();
            $signs = [];

            for ($i = 1; $i <= $signedData->get_Signers(); $i += 1) {
                $signer = $signers->get_Item($i);
                $cert = $signer->get_Certificate();

                $signs [] = (object)[
                    'ts' => $signer->get_SigningTime(),
                    'cert' => new CryptoCertificate($cert)
                ];
            }

            return $signs;
        } catch (Exception $e) {
            return false;
        }
    }
}

