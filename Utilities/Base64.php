<?php

namespace Utilities;


abstract class Base64
{
    /**
     * Create the Base64 binary-safe representation of the given message.
     *
     * The given message can be a binary unsafe string.
     *
     * Example of usage:
     * <code>
     * //this is the binary unsafe message
     * $message = " ... ";
     *
     * //print the result
     * var_dump(Base64::encode($message));
     * </code>
     *
     * @param string $message the binary-unsafe message
     * @param bool $urlCompatible the generated result doesn't contains special characters
     *
     * @return string the binary-safe representation of the given message
     *
     * @throws \InvalidArgumentException the given message is not represented as a string or the URL safety is not boolean
     */
    public static function encode($message, $urlCompatible = true): string
    {
        //check for the message type
        if (!is_string($message)) {
            throw new \InvalidArgumentException('the binary unsafe content must be given as a string');
        }
        //check for url safety param
        if (!is_bool($urlCompatible)) {
            throw new \InvalidArgumentException('the binary unsafe content must be given as a string');
        }
        //get the base64 url unsafe
        $encoded = base64_encode($message);
        //return the url safe version if requested
        return ($urlCompatible) ? rtrim(strtr($encoded, '+/=', '-_~'), '~') : $encoded;
    }

    /**
     * Get the binary-unsafe representation of the given base64-encoded message.
     *
     * This function is compatible with the php standard base64_encode and the
     * framework Base64::encode( ... ).
     *
     * Example of usage:
     * <code>
     * //this is the binary unsafe message
     * $message = " ... ";
     *
     * //print the input string (binary unsafe)
     * var_dump(Base64::decode(Base64::encode($message)));
     * </code>
     *
     * @param string $message a message base64 encoded
     *
     * @return string the message in a binary-unsafe format
     *
     * @throws \InvalidArgumentException the given message is not represented as a string
     */
    public static function decode($message): string
    {
        //check for the message type
        if (!is_string($message)) {
            throw new \InvalidArgumentException('the base64 of a string is represented as another string');
        }
        //is the base64 encoded in an URL safe format?
        $urlCompatible = (strlen($message) % 4) || (strpos($message, '_') !== false) || (strpos($message, '~') !== false);
        //get the base64 encoded valid string and return the decode result
        $validBase64 = ($urlCompatible) ?
            str_pad(strtr($message, '-_~', '+/='), strlen($message) + 4 - (strlen($message) % 4), '=', STR_PAD_RIGHT)
            : $message;
        return base64_decode($validBase64);
    }
}