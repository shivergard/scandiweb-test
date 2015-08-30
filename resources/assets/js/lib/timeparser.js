import _ from 'lodash';

export default class TimeParser {

    /**
     * Parsed string
     *
     * @type {string}
     */
    parsedString = '';

    /**
     * Parsed minutes
     *
     * @type {number}
     */
    parsedMinutes = 0;

    /**
     * Time units
     *
     * @type {object}
     */
    units = {
        month: {
            long: 'month',
            short: 'mo',
            multiplier: 60 * 24 * 30
        },
        week: {
            long: 'week',
            short: 'w',
            multiplier: 60 * 24 * 7
        },
        day: {
            long: 'day',
            short: 'd',
            multiplier: 60 * 24
        },
        hour: {
            long: 'hour',
            short: 'h',
            multiplier: 60
        },
        minute: {
            long: 'minute',
            short: 'm',
            multiplier: 1
        }
    };

    /**
     *
     * @param input
     *
     * @returns {number}
     */
    parse(input) {
        this.parsedString = input;

        // parse case where only number are typed
        if (/^\s*\d+\s*$/.test(this.parsedString)) {

            return this.extractMinutes(this.parsedString, 1);
        }

        _.forEach(this.units, (unit) => {
            var longPattern = '[2-9][0-9]*\\s*' + unit.long + 's(\\s+|\\b)|1\\s*' + unit.long + '(\\s+|\\b)';
            var shortPattern = '\\d+\\s*' + unit.short + '(\\s+|\\b)';
            var longFound = new RegExp(longPattern).test(this.parsedString);
            var shortFound = new RegExp(shortPattern).test(this.parsedString);

            // if both found input is invalid
            if (longFound && shortFound) return false;

            if (longFound) {
                this.matchFoundPatterns(longPattern, unit);
            }

            if (shortFound) {
                this.matchFoundPatterns(shortPattern, unit);
            }
        });

        return this.parsedMinutes;
    }

    /**
     * Match found patterns
     *
     * @param {string} pattern
     * @param {object} unit -- current unit object
     */
    matchFoundPatterns(pattern, unit) {
        var matchedString = this.parsedString.match(pattern)[0];

        // extract minutes and shorten input string
        this.parsedMinutes += this.extractMinutes(matchedString, unit.multiplier);
        this.parsedString = this.parsedString.replace(matchedString, '');
    }

    /**
     * Extract minutes
     *
     * @param {string} input
     * @param {number} multiplier
     * @returns {number}
     */
    extractMinutes(input, multiplier) {
        var match = input.match(/\d+/)[0];
 
        return parseInt(match) * multiplier;
    }
}