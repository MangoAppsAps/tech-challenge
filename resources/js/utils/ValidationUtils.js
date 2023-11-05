/**
 * Validates the format of a given email address
 * 
 * The validation is in its current state not the most robust, 
 * as I'm at this moment not sure of all the rules related 
 * to the format of an email address, but its sufficient.
 * 
 * For the email to be valid it must follow the following rules
 * from the start of the string:
 * 
 * 1. Any characters that are not space or "@"
 * 2. Require "@""
 * 3. Any characters that are not space or "@"
 * 4. Require "."
 * 5. Any characters that are not space or "@" 
 * 
 * @param {string} address 
 * @returns {boolean}
 */
export function isValidEmailAddress(address) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(address.toLowerCase());
} 

/**
 * Validates the format of a given phone number.
 * 
 * For the phone number to be valid it may only include:
 * 1. Digits
 * 2. Spaces
 * 3. Plus signs
 * 
 * @param {string} phone
 * @return {boolean} 
 */
export function isValidPhoneNumber(phone) {
    const re = /^[\d\s+]+$/;
    return re.test(phone);
} 