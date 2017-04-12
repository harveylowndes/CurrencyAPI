<?php

/**
*	The configuration file for the API.
* 
*	@author  Harvey Lowndes	
*/

error_reporting(0); //Error reporting disabled for live site as using custom error handler.

/**
*	URI ENCODED DATA SUPPORT FOR ALL METHODS.
*	USED FOR PUT/DELETE/UPDATE METHODS.
*/
$_INPUT = null;
parse_str(file_get_contents('php://input'), $_INPUT);

/**
*	===== INDEX FILE =====
*/
CONST INDEX_FILE = "conv_";

/**
*	===== TIMESTAMP FORMAT STRING =====
*/
CONST TIMESTAMP_FORMAT = "Y-m-d H:i:s";

/**
*	===== FILE PATHS =====
*/
CONST RATES_XML = "./data/rates.xml";
CONST RATES_XSD = "./data/rates.xsd";

/**
*	===== BASE =====
*/
CONST BASE = 'USD';



/**
*	===== MESSAGE/RESPONSE FORMATS =====
*	To create a new format create a constant called *_MESSAGE_FORMAT where the value
*	equals the name (get value) of the new format and * is the name of the format in 
*	uppercase. Then add the content-type to a constant named *_MESSAGE_CONTENT_TYPE
*	where * also equals the uppercase message format. Then add *_MESSAGE_FORMAT to
*	The VALID_MESSAGE_FORMATS array. 
*	NOTICE: YOU MUST THEN GO THROUGH THIS CONFIGURATION FILE AND WRITE RESPONSE AND
*	ERROR MESSAGE TEMPLATES. THE CONSTANT NAME SHOULD BE THE SAME AS THE PRE-EXISITING 
*	ONES BUT WITH THE NEW FILE NAME AT THE BEGINNING.
*/
CONST XML_MESSAGE_FORMAT = "xml";
CONST XML_MESSAGE_CONTENT_TYPE = 'Content-Type: text/xml';

CONST JSON_MESSAGE_FORMAT = "json";
CONST JSON_MESSAGE_CONTENT_TYPE = 'Content-Type: application/json';

$VALID_MESSAGE_FORMATS = array(XML_MESSAGE_FORMAT, JSON_MESSAGE_FORMAT); //Accepted format values in query string

CONST DEFAULT_MESSAGE_FORMAT = XML_MESSAGE_FORMAT; //DEFAULT MESSAGING FORMAT (IF NONE IS SET IN QUERY STRING)

//CONST MESSAGE_FORMATS = ["xml" => "Content-Type: text/xml", "json" => "Content-Type: application/json"]

/**
*	===== RESPONSE MESSAGE TEMPLATES ===== 
*/

CONST XML_GET_RESPONSE_TEMPLATE = '<?xml version="1.0" encoding="UTF-8" ?><conv><at>{{timestamp}}</at><rate>{{conv_rate}}</rate><from><code>{{from_code}}</code><curr>{{from_name}}</curr><loc>{{from_locations}}</loc><amnt>{{amount}}</amnt></from><to><code>{{to_code}}</code><curr>{{to_name}}</curr><loc>{{to_locations}}</loc><amnt>{{total}}</amnt></to></conv>';
CONST JSON_GET_RESPONSE_TEMPLATE = '{"conv": {"at": "{{timestamp}}","rate": {{conv_rate}},"from": {"code": "{{from_code}}","curr": "{{from_name}}","loc": "{{from_locations}}","amnt": {{amount}} },"to": {"code": "{{to_code}}","curr": "{{to_name}}","loc": "{{to_locations}}","amnt": {{total}} }}}';

CONST XML_POST_RESPONSE_TEMPLATE = '<?xml version="1.0" encoding="UTF-8" ?><method type="{{request}}"><at>{{timestamp}}</at><previous><rate>{{previous_rate}}</rate><curr><code>{{code}}</code><name>{{name}}</name><loc>{{locations}}</loc></curr></previous><new><rate>{{new_rate}}</rate><curr><code>{{code}}</code><name>{{name}}</name><loc>{{locations}}</loc></curr></new></method>';
CONST JSON_POST_RESPONSE_TEMPLATE = '{ "method": { "at": "{{timestamp}}", "previous": { "rate": {{previous_rate}}, "curr": { "code": "{{code}}", "name": "{{name}}", "loc": "{{locations}}" } }, "new": { "rate": {{new_rate}}, "curr": { "code": "{{code}}", "name": "{{name}}", "loc": "{{locations}}" } }, "_type": "{{request}}" }}';

CONST XML_DELETE_RESPONSE_TEMPLATE = '<?xml version="1.0" encoding="UTF-8" ?><method type="{{request}}"><at>{{timestamp}}</at><code>{{code}}</code></method>';
CONST JSON_DELETE_RESPONSE_TEMPLATE = '{ "method": { "at": "{{timestamp}}", "code": "{{code}}" } "_type": "{{request}}" }';

CONST XML_PUT_RESPONSE_TEMPLATE = '<?xml version="1.0" encoding="UTF-8" ?><method type="{{request}}"><at>{{timestamp}}</at><rate>{{rate}}</rate><curr><code>{{code}}</code><name>{{name}}</name><loc>{{locations}}</loc></curr></method>';
CONST JSON_PUT_RESPONSE_TEMPLATE = '{ "method": { "-type": "{{request}}", "at": "{{timestamp}}", "rate": "{{rate}}", "curr": { "code": "{{code}}", "name": "{{name}}", "loc": "{{locations}}" } } }';

/**
*	====== ERROR RESONSE MESSAGES =====
*/

CONST ERROR_TITLE = "ERROR"; //DOESN'T DO ANYTHING IN CODE - KEPT FOR POSSIBLE EXTENTION AND NEEDED FOR PARAMETER.

/**	
*	== ERROR RESPONSE MESSAGE TEMPLATES == 
*/

/** FOR GET REQUEST ERRORS */
CONST XML_GET_ERROR_TEMPLATE = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><conv><error><code>{{code}}</code><msg>{{message}}</msg></error></conv>";
CONST JSON_GET_ERROR_TEMPLATE = "{ \"conv\": { \"error\": { \"code\": \"{{code}}\", \"msg\": \"{{message}}\" } } }";

/** FOR OTHER REQUEST ERRORS */
CONST XML_ERROR_TEMPLATE = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><method type=\"{{request}}\"><error><code>{{code}}</code><msg>{{message}}</msg></error></method>";
CONST JSON_ERROR_TEMPLATE = "{ \"method\": { \"-type\": \"{{request}}\", \"error\": { \"code\": \"{{code}}\", \"msg\": \"{{message}}\" } } }";

/** UNIVERSAL ERROR MESSAGES AND CODES */
CONST ERROR_3000 = 3000;
CONST ERROR_3000_MESSAGE = "Format type not recognized.";

/**
* GET ERROR MESSAGES AND CODES
* COULD HAVE PUT IN ARRAY KEY=>VAL
*/
CONST ERROR_1000 = 1000;
CONST ERROR_1000_MESSAGE = "Currency type not recognised.";

CONST ERROR_1100 = 1100;
CONST ERROR_1100_MESSAGE = "Required parameter is missing.";

CONST ERROR_1200 = 1200;
CONST ERROR_1200_MESSAGE = "Parameter not recognized.";

CONST ERROR_1300 = 1300;
CONST ERROR_1300_MESSAGE = "Currency amount must be a decimal number.";

CONST ERROR_1400 = 1400;
CONST ERROR_1400_MESSAGE = "Error in service."; //STILL NEED TO PUT TO USE.

/**	OTHER REQUEST ERROR MESSAGES AND CODES */
CONST ERROR_2000 = 2000;
CONST ERROR_2000_MESSAGE = "Method not recognized or is missing.";

CONST ERROR_2100 = 2100;
CONST ERROR_2100_MESSAGE = "Rate in wrong format or is missing.";

CONST ERROR_2200 = 2200;
CONST ERROR_2200_MESSAGE = "Currency code in wrong format or is missing.";

CONST ERROR_2300 = 2300;
CONST ERROR_2300_MESSAGE = "Location name in wrong format or is missing.";

CONST ERROR_2400 = 2400;
CONST ERROR_2400_MESSAGE = "Currency code not found for update.";

CONST ERROR_2500 = 2500;
CONST ERROR_2500_MESSAGE = "Error in service.";

/**
*	===== XML NODES & ATTRIBUTES - REFACTOR NODES TO ELEMENTS =====
*/
CONST ROOT_NODE = "rates";
CONST TIMESTAMP_NODE = "timestamp";
CONST CURRENCY_NODE = "curr";
CONST LOCATION_NODE = "loc";
CONST CODE_ATTRIBUTE = "code";
CONST RATE_ATTRIBUTE = "rate";
CONST NAME_ATTRIBUTE = "name";

/**
*	===== BASIC DOMXPATH PATHS =====
*/
CONST TIMESTAMP_ELEMENT_PATH = "//timestamp/text()";
CONST CURRENCY_ELEMENT_PATH = "//curr";
/**
*	===== EXTERNAL URLS =====
*/

CONST API_ACCESS_KEY = "0bf889a0d2ac42aa1a9202a124b5571a";
$API_URL = "http://apilayer.net/api/live?access_key=" . API_ACCESS_KEY . "&currencies=AED,AFN,ALL,AMD,ANG,AOA,ARS,AUD,AWG,AZN,BAM,BBD,BDT,BGN,BHD,BIF,BND,BOB,BOV,BRL,BSD,BTN,BWP,BYR,BZD,CAD,CDF,CHE,CHF,CHW,CLF,CLP,CNY,COP,COU,CRC,CUC,CUP,CVE,CZK,DJF,DKK,DOP,DZD,EGP,ERN,ETB,EUR,FJD,FKP,GBP,GEL,GHS,GIP,GMD,GNF,GTQ,GYD,HKD,HNL,HRK,HTG,HUF,IDR,ILS,INR,IQD,IRR,ISK,JMD,JOD,JPY,KES,KGS,KHR,KMF,KPW,KRW,KWD,KYD,KZT,LAK,LBP,LKR,LRD,LSL,LYD,MAD,MDL,MGA,MKD,MMK,MNT,MOP,MRO,MUR,MVR,MWK,MXN,MXV,MYR,MZN,NAD,NGN,NIO,NOK,NPR,NZD,OMR,PAB,PEN,PGK,PHP,PKR,PLN,PYG,QAR,RON,RSD,RUB,RWF,SAR,SBD,SCR,SDG,SEK,SGD,SHP,SLL,SOS,SRD,SSP,STD,SYP,SZL,THB,TJS,TMT,TND,TOP,TRY,TTD,TWD,TZS,UAH,UGX,USD,USN,USS,UYI,UYU,UZS,VEF,VND,VUV,WST,XAF,XAG,XAU,XBA,XBB,XBC,XBD,XCD,XDR,XFU,XOF,XPD,XPF,XPT,XSU,XTS,XUA,XXX,YER,ZAR,ZMW&source=" . BASE . "&format=1";

/**
*	===== QUERY STRING PARAMETERS =====
*/
CONST RATE = 'rate';
CONST CODE = 'code';
CONST NAME = 'name';
CONST LOCATIONS = 'locations';

CONST AMOUNT = 'amnt';
CONST FROM = 'from';
CONST TO = 'to';

CONST FORMAT = 'format';

/*
*	===== VALIDATION =====
*/
CONST MIN_NAME_LENGTH = 3;
CONST MAX_NAME_LENGTH = 50;
?>