import {userCertificate} from './userCertificate';

const CADESCOM_CADES_BES = 1;
const CAPICOM_CURRENT_USER_STORE = 2;
const CAPICOM_MY_STORE = 'My';
const CAPICOM_STORE_OPEN_MAXIMUM_ALLOWED = 2;
const CAPICOM_CERTIFICATE_FIND_SUBJECT_NAME = 1;
const CADESCOM_BASE64_TO_BINARY = 1;
const CERT_DATA_ENCIPHERMENT_KEY_USAGE = 0x10;
const CERT_KEY_ENCIPHERMENT_KEY_USAGE = 0x20;
const CERT_DIGITAL_SIGNATURE_KEY_USAGE = 0x80;
const CERT_NON_REPUDIATION_KEY_USAGE = 0x40;
const AT_KEYEXCHANGE = 1;
const XCN_CRYPT_STRING_BASE64HEADER = 0;
const XCN_NCRYPT_ALLOW_EXPORT_FLAG = 1;

export function CreateCertRequest(containerName, customDistinguishedName) {
    return new Promise((resolve, reject) => {
        window.cadesplugin.async_spawn(function* (args) {
            var PKey = yield window.cadesplugin.CreateObjectAsync(
                'X509Enrollment.CX509PrivateKey'
            );

            yield PKey.propset_ProviderName(
                'Crypto-Pro GOST R 34.10-2012 Cryptographic Service Provider'
            );
            yield PKey.propset_ProviderType(80);
            yield PKey.propset_KeySpec(AT_KEYEXCHANGE); // XCN_AT_KEYEXCHANGE
            yield PKey.propset_ContainerName(containerName);
            yield PKey.propset_ExportPolicy(XCN_NCRYPT_ALLOW_EXPORT_FLAG);

            var CertificateRequestPkcs10 = yield window.cadesplugin.CreateObjectAsync(
                'X509Enrollment.CX509CertificateRequestPkcs10'
            );
            yield CertificateRequestPkcs10.InitializeFromPrivateKey(1, PKey, '');

            var DistinguishedName = yield window.cadesplugin.CreateObjectAsync(
                'X509Enrollment.CX500DistinguishedName'
            );
            yield DistinguishedName.Encode(customDistinguishedName);
            yield CertificateRequestPkcs10.propset_Subject(DistinguishedName);

            var KeyUsageExtension = yield window.cadesplugin.CreateObjectAsync(
                'X509Enrollment.CX509ExtensionKeyUsage'
            );

            yield KeyUsageExtension.InitializeEncode(
                CERT_KEY_ENCIPHERMENT_KEY_USAGE |
                CERT_DATA_ENCIPHERMENT_KEY_USAGE |
                CERT_DIGITAL_SIGNATURE_KEY_USAGE |
                CERT_NON_REPUDIATION_KEY_USAGE
            );

            var extensions = yield CertificateRequestPkcs10.X509Extensions;
            yield extensions.Add(KeyUsageExtension);

            var Enroll = yield window.cadesplugin.CreateObjectAsync(
                'X509Enrollment.CX509Enrollment'
            );
            yield Enroll.InitializeFromRequest(CertificateRequestPkcs10);

            var certReq = yield Enroll.CreateRequest(1);
            resolve(certReq);
        });
    });
}

export function InstallResponseFromCertificate(certificate, password) {
    return new Promise((resolve, reject) => {
        window.cadesplugin.async_spawn(function* (args) {
            var Enroll = yield window.cadesplugin.CreateObjectAsync(
                'X509Enrollment.CX509Enrollment'
            );
            yield Enroll.Initialize(1);
            yield Enroll.InstallResponse(4, certificate, 1, password.toString());
        });
    });
}

export function FileSign(file, certificateCN) {
    const fileReader = new FileReader();

    fileReader.readAsDataURL(file);

    return new Promise((resolve) => {
        fileReader.onload = async function (oFREvent) {
            let fileData = oFREvent.target.result;
            let header = ';base64,';
            let base64FileData = fileData.substr(
                fileData.indexOf(header) + header.length
            );

            let signedMessage = await SignCreate(certificateCN, base64FileData);

            resolve(signedMessage);
        };
    });
}

export function FileSignByThumbprint(file, certificateThumbprint) {
    const fileReader = new FileReader();

    fileReader.readAsDataURL(file);

    return new Promise((resolve) => {
        fileReader.onload = async function (oFREvent) {
            let fileData = oFREvent.target.result;
            let header = ';base64,';
            let base64FileData = fileData.substr(
                fileData.indexOf(header) + header.length
            );

            let signedMessage = await signFileByThumbprint(
                certificateThumbprint,
                base64FileData
            );

            resolve(signedMessage);
        };
    });
}

export function coFileSign(file, sigfile, certificateCN) {
    const fileReader = new FileReader();

    fileReader.readAsDataURL(file);

    return new Promise((resolve) => {
        fileReader.onload = async function (oFREvent) {
            let fileData = oFREvent.target.result;
            let header = ';base64,';
            let base64FileData = fileData.substr(
                fileData.indexOf(header) + header.length
            );

            let signedMessage = await coSignCreate(
                certificateCN,
                base64FileData,
                sigfile
            );

            resolve(signedMessage);
        };
    });
}

export function signFileByThumbprint(certificateThumbprint, dataToSign) {
    return new Promise((resolve, reject) => {
        window.cadesplugin.async_spawn(function* (args) {
            var oStore = yield window.cadesplugin.CreateObjectAsync('CAdESCOM.Store');
            yield oStore.Open(
                CAPICOM_CURRENT_USER_STORE,
                CAPICOM_MY_STORE,
                CAPICOM_STORE_OPEN_MAXIMUM_ALLOWED
            );

            var CertFinder = yield oStore.Certificates;
            var oCertificates = yield CertFinder.Find(
                cadesplugin.CAPICOM_CERTIFICATE_FIND_SHA1_HASH,
                certificateThumbprint
            );

            if (yield oCertificates.Count === 0) {
                alert('Сертификат не найден ' + certificateCN);
                return;
            }

            oStore.Close();

            var oCertificate = yield oCertificates.Item(1);
            var oSigner = yield window.cadesplugin.CreateObjectAsync(
                'CAdESCOM.CPSigner'
            );
            yield oSigner.propset_Certificate(oCertificate);

            var oSignedData = yield window.cadesplugin.CreateObjectAsync(
                'CAdESCOM.CadesSignedData'
            );
            yield oSignedData.propset_ContentEncoding(
                cadesplugin.CADESCOM_BASE64_TO_BINARY
            );
            yield oSignedData.propset_Content(dataToSign);

            var sSignedMessage = yield oSignedData.SignCades(
                oSigner,
                CADESCOM_CADES_BES,
                true
            );

            resolve(sSignedMessage);
        });
    });
}

export function signByThumbprint(certificateThumbprint, dataToSign) {
    return new Promise((resolve, reject) => {
        window.cadesplugin.async_spawn(function* (args) {
            var oStore = yield window.cadesplugin.CreateObjectAsync('CAdESCOM.Store');
            yield oStore.Open(
                CAPICOM_CURRENT_USER_STORE,
                CAPICOM_MY_STORE,
                CAPICOM_STORE_OPEN_MAXIMUM_ALLOWED
            );

            var CertFinder = yield oStore.Certificates;
            var oCertificates = yield CertFinder.Find(
                cadesplugin.CAPICOM_CERTIFICATE_FIND_SHA1_HASH,
                certificateThumbprint
            );

            if (yield oCertificates.Count === 0) {
                alert('Сертификат не найден ' + certificateThumbprint);
                return;
            }

            oStore.Close();

            var oCertificate = yield oCertificates.Item(1);
            var oSigner = yield window.cadesplugin.CreateObjectAsync(
                'CAdESCOM.CPSigner'
            );
            yield oSigner.propset_Certificate(oCertificate);

            var oSignedData = yield window.cadesplugin.CreateObjectAsync(
                'CAdESCOM.CadesSignedData'
            );
            yield oSignedData.propset_ContentEncoding(CADESCOM_BASE64_TO_BINARY);
            yield oSignedData.propset_Content(dataToSign);

            var sSignedMessage = yield oSignedData.SignCades(
                oSigner,
                cadesplugin.CADESCOM_CADES_BES,
                true
            );

            resolve(sSignedMessage);
        });
    });
}

function SignCreate(certificateCN, dataToSign) {
    return new Promise((resolve, reject) => {
        window.cadesplugin.async_spawn(function* (args) {
            var oStore = yield window.cadesplugin.CreateObjectAsync('CAdESCOM.Store');
            yield oStore.Open(
                CAPICOM_CURRENT_USER_STORE,
                CAPICOM_MY_STORE,
                CAPICOM_STORE_OPEN_MAXIMUM_ALLOWED
            );

            var CertFinder = yield oStore.Certificates;
            var oCertificates = yield CertFinder.Find(0, certificateCN);

            if (oCertificates.Count === 0) {
                alert('Сертификат не найден ' + certificateCN);
                return;
            }

            oStore.Close();

            var oCertificate = yield oCertificates.Item(1);
            var oSigner = yield window.cadesplugin.CreateObjectAsync(
                'CAdESCOM.CPSigner'
            );
            yield oSigner.propset_Certificate(oCertificate);
            yield oSigner.propset_CheckCertificate(true);
            yield oSigner.propset_TSAAddress('http://cryptopro.ru/tsp/');

            var oSignedData = yield window.cadesplugin.CreateObjectAsync(
                'CAdESCOM.CadesSignedData'
            );
            yield oSignedData.propset_Content(dataToSign);

            var sSignedMessage = yield oSignedData.SignCades(
                oSigner,
                CADESCOM_CADES_BES,
                true
            );

            resolve(sSignedMessage);
        });
    });
}

export function coSignCreate(certificateCN, dataToSign, sig) {
    return new Promise((resolve, reject) => {
        window.cadesplugin.async_spawn(function* (args) {
            var oStore = yield window.cadesplugin.CreateObjectAsync('CAdESCOM.Store');
            yield oStore.Open(
                CAPICOM_CURRENT_USER_STORE,
                CAPICOM_MY_STORE,
                CAPICOM_STORE_OPEN_MAXIMUM_ALLOWED
            );

            var CertFinder = yield oStore.Certificates;
            var oCertificates = yield CertFinder.Find(0, certificateCN);

            if (oCertificates.Count === 0) {
                alert('Сертификат не найден ' + certificateCN);
                return;
            }

            oStore.Close();

            var oCertificate = yield oCertificates.Item(1);
            var oSigner = yield window.cadesplugin.CreateObjectAsync(
                'CAdESCOM.CPSigner'
            );
            yield oSigner.propset_Certificate(oCertificate);
            yield oSigner.propset_CheckCertificate(true);

            var oSignedData = yield window.cadesplugin.CreateObjectAsync(
                'CAdESCOM.CadesSignedData'
            );
            yield oSignedData.propset_ContentEncoding(CADESCOM_BASE64_TO_BINARY);
            yield oSignedData.propset_Content(dataToSign);

            yield oSignedData.VerifyCades(sig, CADESCOM_CADES_BES, true);

            var sSignedData = yield oSignedData.CoSignCades(
                oSigner,
                CADESCOM_CADES_BES
            );

            resolve(sSignedData);
        });
    });
}

export function getCertificates() {
    return new Promise((resolve, reject) => {
        window.cadesplugin.async_spawn(function* (args) {
            const oStore = yield window.cadesplugin.CreateObjectAsync(
                'CAdESCOM.Store'
            );
            yield oStore.Open(
                CAPICOM_CURRENT_USER_STORE,
                CAPICOM_MY_STORE,
                CAPICOM_STORE_OPEN_MAXIMUM_ALLOWED
            );

            let certificates = yield (yield oStore.Certificates).Find(
                cadesplugin.CAPICOM_CERTIFICATE_FIND_TIME_VALID
            );

            resolve(getDetailedCertificates(certificates));
        });
    });
}

export function getCertificatesWithSnils(snils) {
    return new Promise((resolve, reject) => {
        window.cadesplugin.async_spawn(function* (args) {
            const oStore = yield window.cadesplugin.CreateObjectAsync(
                'CAdESCOM.Store'
            );
            yield oStore.Open(
                CAPICOM_CURRENT_USER_STORE,
                CAPICOM_MY_STORE,
                CAPICOM_STORE_OPEN_MAXIMUM_ALLOWED
            );

            const certificates = yield (yield oStore.Certificates).Find(1, snils);

            resolve(getDetailedCertificates(certificates));
        });
    });
}

async function getDetailedCertificates(certificates) {
    const certificatesLength = await certificates.Count;
    let approvedCertificates = [];

    for (let i = 1; i <= certificatesLength; i++) {
        let cert = await certificates.Item(i);
        let subjectName = await cert.SubjectName;
        let issuerName = await cert.IssuerName;
        let userCertificateToAdd = new userCertificate(subjectName, issuerName);

        userCertificateToAdd.serialNumber = await cert.SerialNumber;
        userCertificateToAdd.validFromDate = await cert.ValidFromDate;
        userCertificateToAdd.validToDate = await cert.ValidToDate;
        userCertificateToAdd.thumbprint = await cert.Thumbprint;

        // if(await certificateFilter(cert, userCertificateToAdd)) {
        //      approvedCertificates.push(userCertificateToAdd);
        //  }
        approvedCertificates.push(userCertificateToAdd);
    }
    return approvedCertificates;
}

async function certificateFilter(certificate, userCertificate) {
    let providerType = await (
        await (
            await (await certificate).PublicKey()
        ).Algorithm
    ).FriendlyName;

    if (providerType === 'ГОСТ Р 34.10-2012 256 бит') {
        return true;
    } else {
        return false;
    }
}

function isValid(certificateDate) {
    let certDate = new Date(certificateDate).getTime();
    let todayDate = new Date(Date.now()).getTime();

    return certDate > todayDate;
}
