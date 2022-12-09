import {reactive} from 'vue';

export const cadesplugin_request_creation = reactive({
    async createRequest(containerName, dn, incomingIdentificationKind) {
        return window.cadesplugin.async_spawn(function* (args) {
            const XCN_NCRYPT_ALLOW_EXPORT_FLAG = 1;
            const AT_KEYEXCHANGE = 1;

            var PKey = yield window.cadesplugin.CreateObjectAsync("X509Enrollment.CX509PrivateKey");
            yield PKey.propset_ProviderName('Crypto-Pro GOST R 34.10-2012 Cryptographic Service Provider');
            yield PKey.propset_ProviderType(80);
            yield PKey.propset_KeySpec(AT_KEYEXCHANGE); // XCN_AT_KEYEXCHANGE
            yield PKey.propset_ContainerName(containerName);
            yield PKey.propset_ExportPolicy(XCN_NCRYPT_ALLOW_EXPORT_FLAG);

            var CertificateRequestPkcs10 = yield window.cadesplugin.CreateObjectAsync("X509Enrollment.CX509CertificateRequestPkcs10");
            yield CertificateRequestPkcs10.InitializeFromPrivateKey(0x1, PKey, "");

            var DistinguishedName = yield window.cadesplugin.CreateObjectAsync("X509Enrollment.CX500DistinguishedName");
            yield DistinguishedName.Encode(dn);
            CertificateRequestPkcs10.propset_Subject(DistinguishedName);

            var KeyUsageExtension = yield window.cadesplugin.CreateObjectAsync("X509Enrollment.CX509ExtensionKeyUsage");
            const CERT_DATA_ENCIPHERMENT_KEY_USAGE = 0x10;
            const CERT_KEY_ENCIPHERMENT_KEY_USAGE = 0x20;
            const CERT_DIGITAL_SIGNATURE_KEY_USAGE = 0x80;
            const CERT_NON_REPUDIATION_KEY_USAGE = 0x40;

            yield KeyUsageExtension.InitializeEncode(
                CERT_KEY_ENCIPHERMENT_KEY_USAGE |
                CERT_DATA_ENCIPHERMENT_KEY_USAGE |
                CERT_DIGITAL_SIGNATURE_KEY_USAGE |
                CERT_NON_REPUDIATION_KEY_USAGE);


            var IdentificationKind = yield window.cadesplugin.CreateObjectAsync("X509Enrollment.CX509ExtensionIdentificationKind");
            yield IdentificationKind.InitializeEncode(incomingIdentificationKind)

            var extensions = yield CertificateRequestPkcs10.X509Extensions;
            yield extensions.Add(KeyUsageExtension);
            yield extensions.Add(IdentificationKind);

            var Enroll = yield window.cadesplugin.CreateObjectAsync("X509Enrollment.CX509Enrollment");
            yield Enroll.InitializeFromRequest(CertificateRequestPkcs10);

            var certReq = yield Enroll.CreateRequest(window.cadesplugin.XCN_CRYPT_STRING_BASE64HEADER);
            return yield certReq;
        });
    },
    getIdentificationKind(rawValue) {
        switch (rawValue) {
            case 0: {
                return 0x00;
            }
            case 1: {
                return 0x01;
            }
            case 2: {
                return 0x02;
            }
            case 3: {
                return 0x03;
            }
        }
    },
    toDN(object) {
        let result = "";
        for (const [key, value] of Object.entries(object)) {
            if (key === "2.5.4.3") {
                result = result.concat(`OID.${key}="${value.replace(/"/g, "\"\"").replace(/«/g, "\"").replace(/»/g, "\"")}",`);
            } else if (key === "2.5.4.10") {
                result = result.concat(`OID.${key}="${value.replace(/"/g, "\"\"").replace(/«/g, "\"").replace(/»/g, "\"")}",`);
            } else if (key === "2.5.4.9") {
                result = result.concat(`OID.${key}="${value}",`);
            } else if (key === "2.5.4.8") {
                result = result.concat(`OID.${key}="${value}",`);
            } else if (key === "2.5.4.7") {
                result = result.concat(`OID.${key}="${value}",`);
            } else if (key === "2.5.4.11") {
                result = result.concat(`OID.${key}="${value}",`);
            } else if (key === "2.5.4.42") {
                result = result.concat(`OID.${key}="${value}",`);
            } else if (key === "2.5.4.12") {
                result = result.concat(`OID.${key}="${value}",`);
            } else {
                result = result.concat(`OID.${key}=${value},`);
            }
        }
        result = result.slice(0, -1).replace(/NUMERICSTRING:/gm, "");

        return result;
    }
});
