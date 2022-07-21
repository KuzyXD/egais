export class userCertificate {
  constructor(subject, issuer) {
    this.CN = findCN(subject);
    this.OU = findOU(subject);
    this.O = findO(subject);
    this.STREET = findStreet(subject);
    this.L = findL(subject);
    this.S = findS(subject);
    this.SN = findSN(subject);
    this.G = findG(subject);
    this.C = findC(subject);
    this.INN = findINN(subject);
    this.OGRN = findOGRN(subject);
    this.OGRNIP = findOGRNIP(subject);
    this.SNILS = findSNILS(subject);
    this.E = findE(subject);
    this.BY = findBY(issuer);
  }

  get serialNumber() {
    return this._serialNumber;
  }

  set serialNumber(value) {
    this._serialNumber = value;
  }

  get validFromDate() {
    return this._validFromDate;
  }

  set validFromDate(value) {
    this._validFromDate = new Date(value).toLocaleString('ru', {
      day: 'numeric',
      month: 'numeric',
      year: 'numeric'
    });
  }

  get validToDate() {
    return this._validToDate;
  }

  set validToDate(value) {
    this._validToDate = new Date(value).toLocaleString('ru', {
      day: 'numeric',
      month: 'numeric',
      year: 'numeric'
    });
  }

  get shortInfo() {
    let info = '';

    if (this.SN) {
      info += this.SN + ' ' + this.G + ', ';
    }

    if (this.INN) {
      info += 'ИНН: ' + this.INN + ', ';
    }
    if (this.O) {
      info += 'Компания — ' + this.O + ', ';
    }
    if (this.OGRNIP) {
      info += 'ОГРНИП — ' + this.OGRNIP + ', ';
    }

    info +=
      'выдан: ' +
      this.BY +
      ', действует с ' +
      this.validFromDate +
      ' до ' +
      this.validToDate;

    return info;
  }

  get getAll() {
    return this;
  }
}

function findCN(stringWithData) {
  let regex = new RegExp('(?<=CN=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0].replaceAll('""', '"');
  }

  return null;
}

function findBY(stringWithData) {
  let regex = new RegExp('(?<=CN=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0].replaceAll('""', '"');
  }

  return null;
}

function findOU(stringWithData) {
  let regex = new RegExp('(?<=OU=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findO(stringWithData) {
  let regex = new RegExp('(?<=O=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0].replaceAll('""', '"');
  }

  return null;
}

function findStreet(stringWithData) {
    let regex = new RegExp('(?<=STREET=").*(?=",)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findL(stringWithData) {
  let regex = new RegExp('(?<=L=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findS(stringWithData) {
  let regex = new RegExp('(?<= S=)[А-Яа-я\d ]*(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findSN(stringWithData) {
  let regex = new RegExp('(?<=SN=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findG(stringWithData) {
  let regex = new RegExp('(?<=G=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findC(stringWithData) {
  let regex = new RegExp('(?<=C=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findINN(stringWithData) {
  let regex = new RegExp('(?<=INN=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findOGRN(stringWithData) {
  let regex = new RegExp('(?<=OGRN=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findOGRNIP(stringWithData) {
  let regex = new RegExp('(?<=OGRNIP=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findSNILS(stringWithData) {
  let regex = new RegExp('(?<=SNILS=).*?(?=,)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}

function findE(stringWithData) {
    let regex = new RegExp('(?<=E=).*(?=,|$)');

  if (!(stringWithData.search(regex) === -1)) {
    return stringWithData.match(regex)[0];
  }

  return null;
}
