import {reactive} from 'vue';

export const cadesplugin_certificate_install = reactive({
    installCertificate(base64) {
        window.cadesplugin.async_spawn(function* (args) {
            // Полученный запрос на сертификат необходимо передать в Удостоверяющий Центр
            // В дальнейшем необходимо установить ответ из УЦ (переменная strResponse):
            var objEnrollment = yield cadesplugin.CreateObjectAsync("X509Enrollment.CX509Enrollment");
            var XCN_CRYPT_STRING_BASE64_ANY = 6;
            var ContextUser = 1;
            var AllowNone = 0;

            yield objEnrollment.Initialize(ContextUser);
            yield objEnrollment.InstallResponse(AllowNone, strResponse, XCN_CRYPT_STRING_BASE64_ANY, "");
        });
    },
});
