export class UrTemplate {

    constructor() {
        this.BasisOfActs = '';
        this.identificationKind = 1;
        this.lastName = '';
        this.firstName = '';
        this.middleName = '';
        this.gender = '';
        this.birthDate = '';
        this.position = '';
        this.department = '';
        this.email = '';
        this.phone = '';
        this.passportSerial = '';
        this.passportNumber = '';
        this.passportDate = '';
        this.passportDivision = '';
        this.passportCode = '';
        this.snils = '';
        this.personInn = '';
        this.ogrn = '';
        this.company = '';
        this.inn = '';
        this.kpp = '';
        this.companyPhone = '';
        this.region = '';
        this.city = '';
        this.address = '';
        this.index = '';
        this.headLastName = '';
        this.headFirstName = '';
        this.headMiddleName = '';
        this.HeadPosition = '';
        this.offerJoining = '';
        this.type = 3;
        this.products = '';
    }

    assingData(data) {
        const objectKeys = Object.keys(this);
        
        for (let objectKey of objectKeys) {
            this[objectKey] = data[objectKey];
        }
    }
}
