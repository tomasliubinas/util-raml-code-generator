import { Entity } from 'paysera-http-client-common';

import DateFactory from '../service/DateFactory';

class CorrespondentBank extends Entity {

    /**
     * @return {string}|null
     */
    getBankTitle() {
        return this.get('bank_title');
    }

    /**
     * @param {string} bankTitle
     */
    setBankTitle(bankTitle) {
        this.set('bank_title', bankTitle);
    }

    /**
     * @return {string}|null
     */
    getAccountNumber() {
        return this.get('account_number');
    }

    /**
     * @param {string} accountNumber
     */
    setAccountNumber(accountNumber) {
        this.set('account_number', accountNumber);
    }

    /**
     * @return {string}|null
     */
    getBankCode() {
        return this.get('bank_code');
    }

    /**
     * @param {string} bankCode
     */
    setBankCode(bankCode) {
        this.set('bank_code', bankCode);
    }
}

export default CorrespondentBank;
