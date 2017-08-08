<?php
/**
 * PHP-class for data encryption/decryption.
 * 
 * To make your encryption more secure use salt-parameter:
 *   * Use of integer value adds set amount of extra chars in output result.
 *   * Use of string value adds the percentage amount of extra chars in output result
 *     in relation to amount of given data length.
 * 
 * PHP 5, PHP 7
 * 
 * $package SWSCipher
 * @author Siggala Web Solutions <admin@siggala.com>
 * @link https://www.siggala.com/free-solutions/sws-cipher
 * @version 1.0.0
 * @copyright 2017 Siggala Web Solutions
 * @license MIT License
 * 
 * @param string $data      Data string for encryption/decryption
 * @param string $key       Secret key for encryption/decryption
 * @param int|string $salt 	Number of extra chars or percentage amount (ex. '50%')
 * @param boolean $base64 	Enable or disable base64-encoding. Encoding is enabled by default.
 * 
 * @return string
*/
class SWSCipher {
    
    public static function encrypt( $data, $key, $salt = 0, $base64 = true ) {
    	$dataLength = mb_strlen( $data );
    	$keyLength  = mb_strlen( $key );
    	
    	if( !is_int( $salt ) ) {
    		$salt = abs( round( $dataLength * ( (int) $salt / 100 ) ) );
    	}
    	
        for( $i = 0, $resultArray = []; $i < $dataLength; $i++ ) { 
        	$resultArray[] = chr( ord( $data[$i] ) ^ ord( $key[$i % $keyLength] ) );
        }
        
        for( $i = 0, $max = 0, $saltArray = []; $i < $salt; $i++ ) { 
        	$char = chr( ord( $key[( $i + $salt ) % $keyLength] ) ^ ord( $key[$i % $keyLength] ) );
        	$pos  = round( ord( $char ) ^ ord( $salt ) );
        	
        	while( isset( $saltArray[$pos] ) ) {
        		$pos++;
        	}
        	
        	$saltArray[$pos] = $char;
        }
        
        foreach( $saltArray as $index => $value ) {
        	$pos = $index % count( $resultArray );
        	array_splice( $resultArray, $pos, 0, $value );
        }
        
        return $base64 ? base64_encode( implode( '', $resultArray ) ) : implode( '', $resultArray );  
    }  
    
    public static function decrypt( $data, $key, $salt = 0, $base64 = true ) { 
    	$data        = $base64 ? base64_decode( $data ) : $data;
    	$dataLength  = mb_strlen( $data );
    	$keyLength   = mb_strlen( $key );
    	$resultArray = str_split( $data );
    	
    	if( !is_int( $salt ) ) {
    		$salt = abs( round( $dataLength - ( ( $dataLength * 100 ) / ( 100  + (int) $salt ) ) ) );
    	}
        
        for( $i = 0, $max = 0, $saltArray = []; $i < $salt; $i++ ) { 
        	$char = chr( ord( $key[( $i + $salt ) % $keyLength] ) ^ ord( $key[$i % $keyLength] ) );
        	$pos  = round( ord( $char ) ^ ord( $salt ) );
        	
        	while( isset( $saltArray[$pos] ) ) {
        		$pos++;
        	}
        	
        	$saltArray[$pos] = $char;
        }
        
        foreach( array_reverse( $saltArray, true ) as $index => $value ) {
        	$pos = $index % ( count( $resultArray ) - 1 );
        	array_splice( $resultArray, $pos, 1 );
        }
        
        array_splice( $resultArray, ( $dataLength - $salt ) );
        
        for( $i = 0, $result = ''; $i < count( $resultArray ); $i++ ) { 
        	$result .= chr( ord( $resultArray[$i] ) ^ ord( $key[$i % $keyLength] ) );
        }
        
        return $result; 
	}
}
