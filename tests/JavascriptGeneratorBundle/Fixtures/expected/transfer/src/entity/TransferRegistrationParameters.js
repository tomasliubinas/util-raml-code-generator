import { Entity } from 'paysera-http-client-common';

import ConvertCurrency from '../entity/ConvertCurrency';
import DateFactory from '../service/DateFactory';

class TransferRegistrationParameters extends Entity {

    /**
     * @return {Array.<ConvertCurrency>}
     */
    getConvertCurrency() {
        let data = this.get('convert_currency');
        if (data === null) {
            return [];
        }

        let collection = [];
        for (let value of data) {
            collection.push(new ConvertCurrency(value));
        }

        return collection;
    }

    /**
     * @param {Array.<ConvertCurrency>} convertCurrency
     */
    setConvertCurrency(convertCurrency) {
        let data = [];
        for (let entity of convertCurrency) {
            data.push(entity.data);
        }
        this.data = data;
        }
}

export default TransferRegistrationParameters;
