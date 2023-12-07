<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\Country;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country_code');
            $table->string('currency_code');
            $table->string('population');
            $table->string('capital');
            $table->string('continent');
            $table->timestamps();
        });

        Country::insert([
            [
                "country_code" => "AD",
                "name" => "Andorra",
                "currency_code" => "EUR",
                "population" => "84000",
                "capital" => "Andorra la Vella",
                "continent" => "Europe"
            ],
            [
                "country_code" => "AE",
                "name" => "United Arab Emirates",
                "currency_code" => "AED",
                "population" => "4975593",
                "capital" => "Abu Dhabi",
                "continent" => "Asia"
            ],
            [
                "country_code" => "AF",
                "name" => "Afghanistan",
                "currency_code" => "AFN",
                "population" => "29121286",
                "capital" => "Kabul",
                "continent" => "Asia"
            ],
            [
                "country_code" => "AG",
                "name" => "Antigua and Barbuda",
                "currency_code" => "XCD",
                "population" => "86754",
                "capital" => "St. John's",
                "continent" => "North America"
            ],
            [
                "country_code" => "AI",
                "name" => "Anguilla",
                "currency_code" => "XCD",
                "population" => "13254",
                "capital" => "The Valley",
                "continent" => "North America"
            ],
            [
                "country_code" => "AL",
                "name" => "Albania",
                "currency_code" => "ALL",
                "population" => "2986952",
                "capital" => "Tirana",
                "continent" => "Europe"
            ],
            [
                "country_code" => "AM",
                "name" => "Armenia",
                "currency_code" => "AMD",
                "population" => "2968000",
                "capital" => "Yerevan",
                "continent" => "Asia"
            ],
            [
                "country_code" => "AO",
                "name" => "Angola",
                "currency_code" => "AOA",
                "population" => "13068161",
                "capital" => "Luanda",
                "continent" => "Africa"
            ],
            [
                "country_code" => "AQ",
                "name" => "Antarctica",
                "currency_code" => "",
                "population" => "0",
                "capital" => "",
                "continent" => "Antarctica"
            ],
            [
                "country_code" => "AR",
                "name" => "Argentina",
                "currency_code" => "ARS",
                "population" => "41343201",
                "capital" => "Buenos Aires",
                "continent" => "South America"
            ],
            [
                "country_code" => "AS",
                "name" => "American Samoa",
                "currency_code" => "USD",
                "population" => "57881",
                "capital" => "Pago Pago",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "AT",
                "name" => "Austria",
                "currency_code" => "EUR",
                "population" => "8205000",
                "capital" => "Vienna",
                "continent" => "Europe"
            ],
            [
                "country_code" => "AU",
                "name" => "Australia",
                "currency_code" => "AUD",
                "population" => "21515754",
                "capital" => "Canberra",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "AW",
                "name" => "Aruba",
                "currency_code" => "AWG",
                "population" => "71566",
                "capital" => "Oranjestad",
                "continent" => "North America"
            ],
            [
                "country_code" => "AX",
                "name" => "Åland",
                "currency_code" => "EUR",
                "population" => "26711",
                "capital" => "Mariehamn",
                "continent" => "Europe"
            ],
            [
                "country_code" => "AZ",
                "name" => "Azerbaijan",
                "currency_code" => "AZN",
                "population" => "8303512",
                "capital" => "Baku",
                "continent" => "Asia"
            ],
            [
                "country_code" => "BA",
                "name" => "Bosnia and Herzegovina",
                "currency_code" => "BAM",
                "population" => "4590000",
                "capital" => "Sarajevo",
                "continent" => "Europe"
            ],
            [
                "country_code" => "BB",
                "name" => "Barbados",
                "currency_code" => "BBD",
                "population" => "285653",
                "capital" => "Bridgetown",
                "continent" => "North America"
            ],
            [
                "country_code" => "BD",
                "name" => "Bangladesh",
                "currency_code" => "BDT",
                "population" => "156118464",
                "capital" => "Dhaka",
                "continent" => "Asia"
            ],
            [
                "country_code" => "BE",
                "name" => "Belgium",
                "currency_code" => "EUR",
                "population" => "10403000",
                "capital" => "Brussels",
                "continent" => "Europe"
            ],
            [
                "country_code" => "BF",
                "name" => "Burkina Faso",
                "currency_code" => "XOF",
                "population" => "16241811",
                "capital" => "Ouagadougou",
                "continent" => "Africa"
            ],
            [
                "country_code" => "BG",
                "name" => "Bulgaria",
                "currency_code" => "BGN",
                "population" => "7148785",
                "capital" => "Sofia",
                "continent" => "Europe"
            ],
            [
                "country_code" => "BH",
                "name" => "Bahrain",
                "currency_code" => "BHD",
                "population" => "738004",
                "capital" => "Manama",
                "continent" => "Asia"
            ],
            [
                "country_code" => "BI",
                "name" => "Burundi",
                "currency_code" => "BIF",
                "population" => "9863117",
                "capital" => "Bujumbura",
                "continent" => "Africa"
            ],
            [
                "country_code" => "BJ",
                "name" => "Benin",
                "currency_code" => "XOF",
                "population" => "9056010",
                "capital" => "Porto-Novo",
                "continent" => "Africa"
            ],
            [
                "country_code" => "BL",
                "name" => "Saint Barthélemy",
                "currency_code" => "EUR",
                "population" => "8450",
                "capital" => "Gustavia",
                "continent" => "North America"
            ],
            [
                "country_code" => "BM",
                "name" => "Bermuda",
                "currency_code" => "BMD",
                "population" => "65365",
                "capital" => "Hamilton",
                "continent" => "North America"
            ],
            [
                "country_code" => "BN",
                "name" => "Brunei",
                "currency_code" => "BND",
                "population" => "395027",
                "capital" => "Bandar Seri Begawan",
                "continent" => "Asia"
            ],
            [
                "country_code" => "BO",
                "name" => "Bolivia",
                "currency_code" => "BOB",
                "population" => "9947418",
                "capital" => "Sucre",
                "continent" => "South America"
            ],
            [
                "country_code" => "BQ",
                "name" => "Bonaire",
                "currency_code" => "USD",
                "population" => "18012",
                "capital" => "Kralendijk",
                "continent" => "North America"
            ],
            [
                "country_code" => "BR",
                "name" => "Brazil",
                "currency_code" => "BRL",
                "population" => "201103330",
                "capital" => "Brasília",
                "continent" => "South America"
            ],
            [
                "country_code" => "BS",
                "name" => "Bahamas",
                "currency_code" => "BSD",
                "population" => "301790",
                "capital" => "Nassau",
                "continent" => "North America"
            ],
            [
                "country_code" => "BT",
                "name" => "Bhutan",
                "currency_code" => "BTN",
                "population" => "699847",
                "capital" => "Thimphu",
                "continent" => "Asia"
            ],
            [
                "country_code" => "BV",
                "name" => "Bouvet Island",
                "currency_code" => "NOK",
                "population" => "0",
                "capital" => "",
                "continent" => "Antarctica"
            ],
            [
                "country_code" => "BW",
                "name" => "Botswana",
                "currency_code" => "BWP",
                "population" => "2029307",
                "capital" => "Gaborone",
                "continent" => "Africa"
            ],
            [
                "country_code" => "BY",
                "name" => "Belarus",
                "currency_code" => "BYR",
                "population" => "9685000",
                "capital" => "Minsk",
                "continent" => "Europe"
            ],
            [
                "country_code" => "BZ",
                "name" => "Belize",
                "currency_code" => "BZD",
                "population" => "314522",
                "capital" => "Belmopan",
                "continent" => "North America"
            ],
            [
                "country_code" => "CA",
                "name" => "Canada",
                "currency_code" => "CAD",
                "population" => "33679000",
                "capital" => "Ottawa",
                "continent" => "North America"
            ],
            [
                "country_code" => "CC",
                "name" => "Cocos [Keeling] Islands",
                "currency_code" => "AUD",
                "population" => "628",
                "capital" => "West Island",
                "continent" => "Asia"
            ],
            [
                "country_code" => "CD",
                "name" => "Democratic Republic of the Congo",
                "currency_code" => "CDF",
                "population" => "70916439",
                "capital" => "Kinshasa",
                "continent" => "Africa"
            ],
            [
                "country_code" => "CF",
                "name" => "Central African Republic",
                "currency_code" => "XAF",
                "population" => "4844927",
                "capital" => "Bangui",
                "continent" => "Africa"
            ],
            [
                "country_code" => "CG",
                "name" => "Republic of the Congo",
                "currency_code" => "XAF",
                "population" => "3039126",
                "capital" => "Brazzaville",
                "continent" => "Africa"
            ],
            [
                "country_code" => "CH",
                "name" => "Switzerland",
                "currency_code" => "CHF",
                "population" => "7581000",
                "capital" => "Bern",
                "continent" => "Europe"
            ],
            [
                "country_code" => "CI",
                "name" => "Ivory Coast",
                "currency_code" => "XOF",
                "population" => "21058798",
                "capital" => "Yamoussoukro",
                "continent" => "Africa"
            ],
            [
                "country_code" => "CK",
                "name" => "Cook Islands",
                "currency_code" => "NZD",
                "population" => "21388",
                "capital" => "Avarua",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "CL",
                "name" => "Chile",
                "currency_code" => "CLP",
                "population" => "16746491",
                "capital" => "Santiago",
                "continent" => "South America"
            ],
            [
                "country_code" => "CM",
                "name" => "Cameroon",
                "currency_code" => "XAF",
                "population" => "19294149",
                "capital" => "Yaoundé",
                "continent" => "Africa"
            ],
            [
                "country_code" => "CN",
                "name" => "China",
                "currency_code" => "CNY",
                "population" => "1330044000",
                "capital" => "Beijing",
                "continent" => "Asia"
            ],
            [
                "country_code" => "CO",
                "name" => "Colombia",
                "currency_code" => "COP",
                "population" => "47790000",
                "capital" => "Bogotá",
                "continent" => "South America"
            ],
            [
                "country_code" => "CR",
                "name" => "Costa Rica",
                "currency_code" => "CRC",
                "population" => "4516220",
                "capital" => "San José",
                "continent" => "North America"
            ],
            [
                "country_code" => "CU",
                "name" => "Cuba",
                "currency_code" => "CUP",
                "population" => "11423000",
                "capital" => "Havana",
                "continent" => "North America"
            ],
            [
                "country_code" => "CV",
                "name" => "Cape Verde",
                "currency_code" => "CVE",
                "population" => "508659",
                "capital" => "Praia",
                "continent" => "Africa"
            ],
            [
                "country_code" => "CW",
                "name" => "Curacao",
                "currency_code" => "ANG",
                "population" => "141766",
                "capital" => "Willemstad",
                "continent" => "North America"
            ],
            [
                "country_code" => "CX",
                "name" => "Christmas Island",
                "currency_code" => "AUD",
                "population" => "1500",
                "capital" => "Flying Fish Cove",
                "continent" => "Asia"
            ],
            [
                "country_code" => "CY",
                "name" => "Cyprus",
                "currency_code" => "EUR",
                "population" => "1102677",
                "capital" => "Nicosia",
                "continent" => "Europe"
            ],
            [
                "country_code" => "CZ",
                "name" => "Czechia",
                "currency_code" => "CZK",
                "population" => "10476000",
                "capital" => "Prague",
                "continent" => "Europe"
            ],
            [
                "country_code" => "DE",
                "name" => "Germany",
                "currency_code" => "EUR",
                "population" => "81802257",
                "capital" => "Berlin",
                "continent" => "Europe"
            ],
            [
                "country_code" => "DJ",
                "name" => "Djibouti",
                "currency_code" => "DJF",
                "population" => "740528",
                "capital" => "Djibouti",
                "continent" => "Africa"
            ],
            [
                "country_code" => "DK",
                "name" => "Denmark",
                "currency_code" => "DKK",
                "population" => "5484000",
                "capital" => "Copenhagen",
                "continent" => "Europe"
            ],
            [
                "country_code" => "DM",
                "name" => "Dominica",
                "currency_code" => "XCD",
                "population" => "72813",
                "capital" => "Roseau",
                "continent" => "North America"
            ],
            [
                "country_code" => "DO",
                "name" => "Dominican Republic",
                "currency_code" => "DOP",
                "population" => "9823821",
                "capital" => "Santo Domingo",
                "continent" => "North America"
            ],
            [
                "country_code" => "DZ",
                "name" => "Algeria",
                "currency_code" => "DZD",
                "population" => "34586184",
                "capital" => "Algiers",
                "continent" => "Africa"
            ],
            [
                "country_code" => "EC",
                "name" => "Ecuador",
                "currency_code" => "USD",
                "population" => "14790608",
                "capital" => "Quito",
                "continent" => "South America"
            ],
            [
                "country_code" => "EE",
                "name" => "Estonia",
                "currency_code" => "EUR",
                "population" => "1291170",
                "capital" => "Tallinn",
                "continent" => "Europe"
            ],
            [
                "country_code" => "EG",
                "name" => "Egypt",
                "currency_code" => "EGP",
                "population" => "80471869",
                "capital" => "Cairo",
                "continent" => "Africa"
            ],
            [
                "country_code" => "EH",
                "name" => "Western Sahara",
                "currency_code" => "MAD",
                "population" => "273008",
                "capital" => "Laâyoune / El Aaiún",
                "continent" => "Africa"
            ],
            [
                "country_code" => "ER",
                "name" => "Eritrea",
                "currency_code" => "ERN",
                "population" => "5792984",
                "capital" => "Asmara",
                "continent" => "Africa"
            ],
            [
                "country_code" => "ES",
                "name" => "Spain",
                "currency_code" => "EUR",
                "population" => "46505963",
                "capital" => "Madrid",
                "continent" => "Europe"
            ],
            [
                "country_code" => "ET",
                "name" => "Ethiopia",
                "currency_code" => "ETB",
                "population" => "88013491",
                "capital" => "Addis Ababa",
                "continent" => "Africa"
            ],
            [
                "country_code" => "FI",
                "name" => "Finland",
                "currency_code" => "EUR",
                "population" => "5244000",
                "capital" => "Helsinki",
                "continent" => "Europe"
            ],
            [
                "country_code" => "FJ",
                "name" => "Fiji",
                "currency_code" => "FJD",
                "population" => "875983",
                "capital" => "Suva",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "FK",
                "name" => "Falkland Islands",
                "currency_code" => "FKP",
                "population" => "2638",
                "capital" => "Stanley",
                "continent" => "South America"
            ],
            [
                "country_code" => "FM",
                "name" => "Micronesia",
                "currency_code" => "USD",
                "population" => "107708",
                "capital" => "Palikir",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "FO",
                "name" => "Faroe Islands",
                "currency_code" => "DKK",
                "population" => "48228",
                "capital" => "Tórshavn",
                "continent" => "Europe"
            ],
            [
                "country_code" => "FR",
                "name" => "France",
                "currency_code" => "EUR",
                "population" => "64768389",
                "capital" => "Paris",
                "continent" => "Europe"
            ],
            [
                "country_code" => "GA",
                "name" => "Gabon",
                "currency_code" => "XAF",
                "population" => "1545255",
                "capital" => "Libreville",
                "continent" => "Africa"
            ],
            [
                "country_code" => "GB",
                "name" => "United Kingdom",
                "currency_code" => "GBP",
                "population" => "62348447",
                "capital" => "London",
                "continent" => "Europe"
            ],
            [
                "country_code" => "GD",
                "name" => "Grenada",
                "currency_code" => "XCD",
                "population" => "107818",
                "capital" => "St. George's",
                "continent" => "North America"
            ],
            [
                "country_code" => "GE",
                "name" => "Georgia",
                "currency_code" => "GEL",
                "population" => "4630000",
                "capital" => "Tbilisi",
                "continent" => "Asia"
            ],
            [
                "country_code" => "GF",
                "name" => "French Guiana",
                "currency_code" => "EUR",
                "population" => "195506",
                "capital" => "Cayenne",
                "continent" => "South America"
            ],
            [
                "country_code" => "GG",
                "name" => "Guernsey",
                "currency_code" => "GBP",
                "population" => "65228",
                "capital" => "St Peter Port",
                "continent" => "Europe"
            ],
            [
                "country_code" => "GH",
                "name" => "Ghana",
                "currency_code" => "GHS",
                "population" => "24339838",
                "capital" => "Accra",
                "continent" => "Africa"
            ],
            [
                "country_code" => "GI",
                "name" => "Gibraltar",
                "currency_code" => "GIP",
                "population" => "27884",
                "capital" => "Gibraltar",
                "continent" => "Europe"
            ],
            [
                "country_code" => "GL",
                "name" => "Greenland",
                "currency_code" => "DKK",
                "population" => "56375",
                "capital" => "Nuuk",
                "continent" => "North America"
            ],
            [
                "country_code" => "GM",
                "name" => "Gambia",
                "currency_code" => "GMD",
                "population" => "1593256",
                "capital" => "Bathurst",
                "continent" => "Africa"
            ],
            [
                "country_code" => "GN",
                "name" => "Guinea",
                "currency_code" => "GNF",
                "population" => "10324025",
                "capital" => "Conakry",
                "continent" => "Africa"
            ],
            [
                "country_code" => "GP",
                "name" => "Guadeloupe",
                "currency_code" => "EUR",
                "population" => "443000",
                "capital" => "Basse-Terre",
                "continent" => "North America"
            ],
            [
                "country_code" => "GQ",
                "name" => "Equatorial Guinea",
                "currency_code" => "XAF",
                "population" => "1014999",
                "capital" => "Malabo",
                "continent" => "Africa"
            ],
            [
                "country_code" => "GR",
                "name" => "Greece",
                "currency_code" => "EUR",
                "population" => "11000000",
                "capital" => "Athens",
                "continent" => "Europe"
            ],
            [
                "country_code" => "GS",
                "name" => "South Georgia and the South Sandwich Islands",
                "currency_code" => "GBP",
                "population" => "30",
                "capital" => "Grytviken",
                "continent" => "Antarctica"
            ],
            [
                "country_code" => "GT",
                "name" => "Guatemala",
                "currency_code" => "GTQ",
                "population" => "13550440",
                "capital" => "Guatemala City",
                "continent" => "North America"
            ],
            [
                "country_code" => "GU",
                "name" => "Guam",
                "currency_code" => "USD",
                "population" => "159358",
                "capital" => "Hagåtña",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "GW",
                "name" => "Guinea-Bissau",
                "currency_code" => "XOF",
                "population" => "1565126",
                "capital" => "Bissau",
                "continent" => "Africa"
            ],
            [
                "country_code" => "GY",
                "name" => "Guyana",
                "currency_code" => "GYD",
                "population" => "748486",
                "capital" => "Georgetown",
                "continent" => "South America"
            ],
            [
                "country_code" => "HK",
                "name" => "Hong Kong",
                "currency_code" => "HKD",
                "population" => "6898686",
                "capital" => "Hong Kong",
                "continent" => "Asia"
            ],
            [
                "country_code" => "HM",
                "name" => "Heard Island and McDonald Islands",
                "currency_code" => "AUD",
                "population" => "0",
                "capital" => "",
                "continent" => "Antarctica"
            ],
            [
                "country_code" => "HN",
                "name" => "Honduras",
                "currency_code" => "HNL",
                "population" => "7989415",
                "capital" => "Tegucigalpa",
                "continent" => "North America"
            ],
            [
                "country_code" => "HR",
                "name" => "Croatia",
                "currency_code" => "HRK",
                "population" => "4284889",
                "capital" => "Zagreb",
                "continent" => "Europe"
            ],
            [
                "country_code" => "HT",
                "name" => "Haiti",
                "currency_code" => "HTG",
                "population" => "9648924",
                "capital" => "Port-au-Prince",
                "continent" => "North America"
            ],
            [
                "country_code" => "HU",
                "name" => "Hungary",
                "currency_code" => "HUF",
                "population" => "9982000",
                "capital" => "Budapest",
                "continent" => "Europe"
            ],
            [
                "country_code" => "ID",
                "name" => "Indonesia",
                "currency_code" => "IDR",
                "population" => "242968342",
                "capital" => "Jakarta",
                "continent" => "Asia"
            ],
            [
                "country_code" => "IE",
                "name" => "Ireland",
                "currency_code" => "EUR",
                "population" => "4622917",
                "capital" => "Dublin",
                "continent" => "Europe"
            ],
            [
                "country_code" => "IL",
                "name" => "Israel",
                "currency_code" => "ILS",
                "population" => "7353985",
                "capital" => "",
                "continent" => "Asia"
            ],
            [
                "country_code" => "IM",
                "name" => "Isle of Man",
                "currency_code" => "GBP",
                "population" => "75049",
                "capital" => "Douglas",
                "continent" => "Europe"
            ],
            [
                "country_code" => "IN",
                "name" => "India",
                "currency_code" => "INR",
                "population" => "1173108018",
                "capital" => "New Delhi",
                "continent" => "Asia"
            ],
            [
                "country_code" => "IO",
                "name" => "British Indian Ocean Territory",
                "currency_code" => "USD",
                "population" => "4000",
                "capital" => "",
                "continent" => "Asia"
            ],
            [
                "country_code" => "IQ",
                "name" => "Iraq",
                "currency_code" => "IQD",
                "population" => "29671605",
                "capital" => "Baghdad",
                "continent" => "Asia"
            ],
            [
                "country_code" => "IR",
                "name" => "Iran",
                "currency_code" => "IRR",
                "population" => "76923300",
                "capital" => "Tehran",
                "continent" => "Asia"
            ],
            [
                "country_code" => "IS",
                "name" => "Iceland",
                "currency_code" => "ISK",
                "population" => "308910",
                "capital" => "Reykjavik",
                "continent" => "Europe"
            ],
            [
                "country_code" => "IT",
                "name" => "Italy",
                "currency_code" => "EUR",
                "population" => "60340328",
                "capital" => "Rome",
                "continent" => "Europe"
            ],
            [
                "country_code" => "JE",
                "name" => "Jersey",
                "currency_code" => "GBP",
                "population" => "90812",
                "capital" => "Saint Helier",
                "continent" => "Europe"
            ],
            [
                "country_code" => "JM",
                "name" => "Jamaica",
                "currency_code" => "JMD",
                "population" => "2847232",
                "capital" => "Kingston",
                "continent" => "North America"
            ],
            [
                "country_code" => "JO",
                "name" => "Jordan",
                "currency_code" => "JOD",
                "population" => "6407085",
                "capital" => "Amman",
                "continent" => "Asia"
            ],
            [
                "country_code" => "JP",
                "name" => "Japan",
                "currency_code" => "JPY",
                "population" => "127288000",
                "capital" => "Tokyo",
                "continent" => "Asia"
            ],
            [
                "country_code" => "KE",
                "name" => "Kenya",
                "currency_code" => "KES",
                "population" => "40046566",
                "capital" => "Nairobi",
                "continent" => "Africa"
            ],
            [
                "country_code" => "KG",
                "name" => "Kyrgyzstan",
                "currency_code" => "KGS",
                "population" => "5776500",
                "capital" => "Bishkek",
                "continent" => "Asia"
            ],
            [
                "country_code" => "KH",
                "name" => "Cambodia",
                "currency_code" => "KHR",
                "population" => "14453680",
                "capital" => "Phnom Penh",
                "continent" => "Asia"
            ],
            [
                "country_code" => "KI",
                "name" => "Kiribati",
                "currency_code" => "AUD",
                "population" => "92533",
                "capital" => "Tarawa",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "KM",
                "name" => "Comoros",
                "currency_code" => "KMF",
                "population" => "773407",
                "capital" => "Moroni",
                "continent" => "Africa"
            ],
            [
                "country_code" => "KN",
                "name" => "Saint Kitts and Nevis",
                "currency_code" => "XCD",
                "population" => "51134",
                "capital" => "Basseterre",
                "continent" => "North America"
            ],
            [
                "country_code" => "KP",
                "name" => "North Korea",
                "currency_code" => "KPW",
                "population" => "22912177",
                "capital" => "Pyongyang",
                "continent" => "Asia"
            ],
            [
                "country_code" => "KR",
                "name" => "South Korea",
                "currency_code" => "KRW",
                "population" => "48422644",
                "capital" => "Seoul",
                "continent" => "Asia"
            ],
            [
                "country_code" => "KW",
                "name" => "Kuwait",
                "currency_code" => "KWD",
                "population" => "2789132",
                "capital" => "Kuwait City",
                "continent" => "Asia"
            ],
            [
                "country_code" => "KY",
                "name" => "Cayman Islands",
                "currency_code" => "KYD",
                "population" => "44270",
                "capital" => "George Town",
                "continent" => "North America"
            ],
            [
                "country_code" => "KZ",
                "name" => "Kazakhstan",
                "currency_code" => "KZT",
                "population" => "15340000",
                "capital" => "Astana",
                "continent" => "Asia"
            ],
            [
                "country_code" => "LA",
                "name" => "Laos",
                "currency_code" => "LAK",
                "population" => "6368162",
                "capital" => "Vientiane",
                "continent" => "Asia"
            ],
            [
                "country_code" => "LB",
                "name" => "Lebanon",
                "currency_code" => "LBP",
                "population" => "4125247",
                "capital" => "Beirut",
                "continent" => "Asia"
            ],
            [
                "country_code" => "LC",
                "name" => "Saint Lucia",
                "currency_code" => "XCD",
                "population" => "160922",
                "capital" => "Castries",
                "continent" => "North America"
            ],
            [
                "country_code" => "LI",
                "name" => "Liechtenstein",
                "currency_code" => "CHF",
                "population" => "35000",
                "capital" => "Vaduz",
                "continent" => "Europe"
            ],
            [
                "country_code" => "LK",
                "name" => "Sri Lanka",
                "currency_code" => "LKR",
                "population" => "21513990",
                "capital" => "Colombo",
                "continent" => "Asia"
            ],
            [
                "country_code" => "LR",
                "name" => "Liberia",
                "currency_code" => "LRD",
                "population" => "3685076",
                "capital" => "Monrovia",
                "continent" => "Africa"
            ],
            [
                "country_code" => "LS",
                "name" => "Lesotho",
                "currency_code" => "LSL",
                "population" => "1919552",
                "capital" => "Maseru",
                "continent" => "Africa"
            ],
            [
                "country_code" => "LT",
                "name" => "Lithuania",
                "currency_code" => "EUR",
                "population" => "2944459",
                "capital" => "Vilnius",
                "continent" => "Europe"
            ],
            [
                "country_code" => "LU",
                "name" => "Luxembourg",
                "currency_code" => "EUR",
                "population" => "497538",
                "capital" => "Luxembourg",
                "continent" => "Europe"
            ],
            [
                "country_code" => "LV",
                "name" => "Latvia",
                "currency_code" => "EUR",
                "population" => "2217969",
                "capital" => "Riga",
                "continent" => "Europe"
            ],
            [
                "country_code" => "LY",
                "name" => "Libya",
                "currency_code" => "LYD",
                "population" => "6461454",
                "capital" => "Tripoli",
                "continent" => "Africa"
            ],
            [
                "country_code" => "MA",
                "name" => "Morocco",
                "currency_code" => "MAD",
                "population" => "33848242",
                "capital" => "Rabat",
                "continent" => "Africa"
            ],
            [
                "country_code" => "MC",
                "name" => "Monaco",
                "currency_code" => "EUR",
                "population" => "32965",
                "capital" => "Monaco",
                "continent" => "Europe"
            ],
            [
                "country_code" => "MD",
                "name" => "Moldova",
                "currency_code" => "MDL",
                "population" => "4324000",
                "capital" => "Chişinău",
                "continent" => "Europe"
            ],
            [
                "country_code" => "ME",
                "name" => "Montenegro",
                "currency_code" => "EUR",
                "population" => "666730",
                "capital" => "Podgorica",
                "continent" => "Europe"
            ],
            [
                "country_code" => "MF",
                "name" => "Saint Martin",
                "currency_code" => "EUR",
                "population" => "35925",
                "capital" => "Marigot",
                "continent" => "North America"
            ],
            [
                "country_code" => "MG",
                "name" => "Madagascar",
                "currency_code" => "MGA",
                "population" => "21281844",
                "capital" => "Antananarivo",
                "continent" => "Africa"
            ],
            [
                "country_code" => "MH",
                "name" => "Marshall Islands",
                "currency_code" => "USD",
                "population" => "65859",
                "capital" => "Majuro",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "MK",
                "name" => "Macedonia",
                "currency_code" => "MKD",
                "population" => "2062294",
                "capital" => "Skopje",
                "continent" => "Europe"
            ],
            [
                "country_code" => "ML",
                "name" => "Mali",
                "currency_code" => "XOF",
                "population" => "13796354",
                "capital" => "Bamako",
                "continent" => "Africa"
            ],
            [
                "country_code" => "MM",
                "name" => "Myanmar [Burma]",
                "currency_code" => "MMK",
                "population" => "53414374",
                "capital" => "Naypyitaw",
                "continent" => "Asia"
            ],
            [
                "country_code" => "MN",
                "name" => "Mongolia",
                "currency_code" => "MNT",
                "population" => "3086918",
                "capital" => "Ulan Bator",
                "continent" => "Asia"
            ],
            [
                "country_code" => "MO",
                "name" => "Macao",
                "currency_code" => "MOP",
                "population" => "449198",
                "capital" => "Macao",
                "continent" => "Asia"
            ],
            [
                "country_code" => "MP",
                "name" => "Northern Mariana Islands",
                "currency_code" => "USD",
                "population" => "53883",
                "capital" => "Saipan",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "MQ",
                "name" => "Martinique",
                "currency_code" => "EUR",
                "population" => "432900",
                "capital" => "Fort-de-France",
                "continent" => "North America"
            ],
            [
                "country_code" => "MR",
                "name" => "Mauritania",
                "currency_code" => "MRO",
                "population" => "3205060",
                "capital" => "Nouakchott",
                "continent" => "Africa"
            ],
            [
                "country_code" => "MS",
                "name" => "Montserrat",
                "currency_code" => "XCD",
                "population" => "9341",
                "capital" => "Plymouth",
                "continent" => "North America"
            ],
            [
                "country_code" => "MT",
                "name" => "Malta",
                "currency_code" => "EUR",
                "population" => "403000",
                "capital" => "Valletta",
                "continent" => "Europe"
            ],
            [
                "country_code" => "MU",
                "name" => "Mauritius",
                "currency_code" => "MUR",
                "population" => "1294104",
                "capital" => "Port Louis",
                "continent" => "Africa"
            ],
            [
                "country_code" => "MV",
                "name" => "Maldives",
                "currency_code" => "MVR",
                "population" => "395650",
                "capital" => "Malé",
                "continent" => "Asia"
            ],
            [
                "country_code" => "MW",
                "name" => "Malawi",
                "currency_code" => "MWK",
                "population" => "15447500",
                "capital" => "Lilongwe",
                "continent" => "Africa"
            ],
            [
                "country_code" => "MX",
                "name" => "Mexico",
                "currency_code" => "MXN",
                "population" => "112468855",
                "capital" => "Mexico City",
                "continent" => "North America"
            ],
            [
                "country_code" => "MY",
                "name" => "Malaysia",
                "currency_code" => "MYR",
                "population" => "28274729",
                "capital" => "Kuala Lumpur",
                "continent" => "Asia"
            ],
            [
                "country_code" => "MZ",
                "name" => "Mozambique",
                "currency_code" => "MZN",
                "population" => "22061451",
                "capital" => "Maputo",
                "continent" => "Africa"
            ],
            [
                "country_code" => "NA",
                "name" => "Namibia",
                "currency_code" => "NAD",
                "population" => "2128471",
                "capital" => "Windhoek",
                "continent" => "Africa"
            ],
            [
                "country_code" => "NC",
                "name" => "New Caledonia",
                "currency_code" => "XPF",
                "population" => "216494",
                "capital" => "Noumea",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "NE",
                "name" => "Niger",
                "currency_code" => "XOF",
                "population" => "15878271",
                "capital" => "Niamey",
                "continent" => "Africa"
            ],
            [
                "country_code" => "NF",
                "name" => "Norfolk Island",
                "currency_code" => "AUD",
                "population" => "1828",
                "capital" => "Kingston",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "NG",
                "name" => "Nigeria",
                "currency_code" => "NGN",
                "population" => "154000000",
                "capital" => "Abuja",
                "continent" => "Africa"
            ],
            [
                "country_code" => "NI",
                "name" => "Nicaragua",
                "currency_code" => "NIO",
                "population" => "5995928",
                "capital" => "Managua",
                "continent" => "North America"
            ],
            [
                "country_code" => "NL",
                "name" => "Netherlands",
                "currency_code" => "EUR",
                "population" => "16645000",
                "capital" => "Amsterdam",
                "continent" => "Europe"
            ],
            [
                "country_code" => "NO",
                "name" => "Norway",
                "currency_code" => "NOK",
                "population" => "5009150",
                "capital" => "Oslo",
                "continent" => "Europe"
            ],
            [
                "country_code" => "NP",
                "name" => "Nepal",
                "currency_code" => "NPR",
                "population" => "28951852",
                "capital" => "Kathmandu",
                "continent" => "Asia"
            ],
            [
                "country_code" => "NR",
                "name" => "Nauru",
                "currency_code" => "AUD",
                "population" => "10065",
                "capital" => "Yaren",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "NU",
                "name" => "Niue",
                "currency_code" => "NZD",
                "population" => "2166",
                "capital" => "Alofi",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "NZ",
                "name" => "New Zealand",
                "currency_code" => "NZD",
                "population" => "4252277",
                "capital" => "Wellington",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "OM",
                "name" => "Oman",
                "currency_code" => "OMR",
                "population" => "2967717",
                "capital" => "Muscat",
                "continent" => "Asia"
            ],
            [
                "country_code" => "PA",
                "name" => "Panama",
                "currency_code" => "PAB",
                "population" => "3410676",
                "capital" => "Panama City",
                "continent" => "North America"
            ],
            [
                "country_code" => "PE",
                "name" => "Peru",
                "currency_code" => "PEN",
                "population" => "29907003",
                "capital" => "Lima",
                "continent" => "South America"
            ],
            [
                "country_code" => "PF",
                "name" => "French Polynesia",
                "currency_code" => "XPF",
                "population" => "270485",
                "capital" => "Papeete",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "PG",
                "name" => "Papua New Guinea",
                "currency_code" => "PGK",
                "population" => "6064515",
                "capital" => "Port Moresby",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "PH",
                "name" => "Philippines",
                "currency_code" => "PHP",
                "population" => "99900177",
                "capital" => "Manila",
                "continent" => "Asia"
            ],
            [
                "country_code" => "PK",
                "name" => "Pakistan",
                "currency_code" => "PKR",
                "population" => "184404791",
                "capital" => "Islamabad",
                "continent" => "Asia"
            ],
            [
                "country_code" => "PL",
                "name" => "Poland",
                "currency_code" => "PLN",
                "population" => "38500000",
                "capital" => "Warsaw",
                "continent" => "Europe"
            ],
            [
                "country_code" => "PM",
                "name" => "Saint Pierre and Miquelon",
                "currency_code" => "EUR",
                "population" => "7012",
                "capital" => "Saint-Pierre",
                "continent" => "North America"
            ],
            [
                "country_code" => "PN",
                "name" => "Pitcairn Islands",
                "currency_code" => "NZD",
                "population" => "46",
                "capital" => "Adamstown",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "PR",
                "name" => "Puerto Rico",
                "currency_code" => "USD",
                "population" => "3916632",
                "capital" => "San Juan",
                "continent" => "North America"
            ],
            [
                "country_code" => "PS",
                "name" => "Palestine",
                "currency_code" => "ILS",
                "population" => "3800000",
                "capital" => "",
                "continent" => "Asia"
            ],
            [
                "country_code" => "PT",
                "name" => "Portugal",
                "currency_code" => "EUR",
                "population" => "10676000",
                "capital" => "Lisbon",
                "continent" => "Europe"
            ],
            [
                "country_code" => "PW",
                "name" => "Palau",
                "currency_code" => "USD",
                "population" => "19907",
                "capital" => "Melekeok",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "PY",
                "name" => "Paraguay",
                "currency_code" => "PYG",
                "population" => "6375830",
                "capital" => "Asunción",
                "continent" => "South America"
            ],
            [
                "country_code" => "QA",
                "name" => "Qatar",
                "currency_code" => "QAR",
                "population" => "840926",
                "capital" => "Doha",
                "continent" => "Asia"
            ],
            [
                "country_code" => "RE",
                "name" => "Réunion",
                "currency_code" => "EUR",
                "population" => "776948",
                "capital" => "Saint-Denis",
                "continent" => "Africa"
            ],
            [
                "country_code" => "RO",
                "name" => "Romania",
                "currency_code" => "RON",
                "population" => "21959278",
                "capital" => "Bucharest",
                "continent" => "Europe"
            ],
            [
                "country_code" => "RS",
                "name" => "Serbia",
                "currency_code" => "RSD",
                "population" => "7344847",
                "capital" => "Belgrade",
                "continent" => "Europe"
            ],
            [
                "country_code" => "RU",
                "name" => "Russia",
                "currency_code" => "RUB",
                "population" => "140702000",
                "capital" => "Moscow",
                "continent" => "Europe"
            ],
            [
                "country_code" => "RW",
                "name" => "Rwanda",
                "currency_code" => "RWF",
                "population" => "11055976",
                "capital" => "Kigali",
                "continent" => "Africa"
            ],
            [
                "country_code" => "SA",
                "name" => "Saudi Arabia",
                "currency_code" => "SAR",
                "population" => "25731776",
                "capital" => "Riyadh",
                "continent" => "Asia"
            ],
            [
                "country_code" => "SB",
                "name" => "Solomon Islands",
                "currency_code" => "SBD",
                "population" => "559198",
                "capital" => "Honiara",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "SC",
                "name" => "Seychelles",
                "currency_code" => "SCR",
                "population" => "88340",
                "capital" => "Victoria",
                "continent" => "Africa"
            ],
            [
                "country_code" => "SD",
                "name" => "Sudan",
                "currency_code" => "SDG",
                "population" => "35000000",
                "capital" => "Khartoum",
                "continent" => "Africa"
            ],
            [
                "country_code" => "SE",
                "name" => "Sweden",
                "currency_code" => "SEK",
                "population" => "9828655",
                "capital" => "Stockholm",
                "continent" => "Europe"
            ],
            [
                "country_code" => "SG",
                "name" => "Singapore",
                "currency_code" => "SGD",
                "population" => "4701069",
                "capital" => "Singapore",
                "continent" => "Asia"
            ],
            [
                "country_code" => "SH",
                "name" => "Saint Helena",
                "currency_code" => "SHP",
                "population" => "7460",
                "capital" => "Jamestown",
                "continent" => "Africa"
            ],
            [
                "country_code" => "SI",
                "name" => "Slovenia",
                "currency_code" => "EUR",
                "population" => "2007000",
                "capital" => "Ljubljana",
                "continent" => "Europe"
            ],
            [
                "country_code" => "SJ",
                "name" => "Svalbard and Jan Mayen",
                "currency_code" => "NOK",
                "population" => "2550",
                "capital" => "Longyearbyen",
                "continent" => "Europe"
            ],
            [
                "country_code" => "SK",
                "name" => "Slovakia",
                "currency_code" => "EUR",
                "population" => "5455000",
                "capital" => "Bratislava",
                "continent" => "Europe"
            ],
            [
                "country_code" => "SL",
                "name" => "Sierra Leone",
                "currency_code" => "SLL",
                "population" => "5245695",
                "capital" => "Freetown",
                "continent" => "Africa"
            ],
            [
                "country_code" => "SM",
                "name" => "San Marino",
                "currency_code" => "EUR",
                "population" => "31477",
                "capital" => "San Marino",
                "continent" => "Europe"
            ],
            [
                "country_code" => "SN",
                "name" => "Senegal",
                "currency_code" => "XOF",
                "population" => "12323252",
                "capital" => "Dakar",
                "continent" => "Africa"
            ],
            [
                "country_code" => "SO",
                "name" => "Somalia",
                "currency_code" => "SOS",
                "population" => "10112453",
                "capital" => "Mogadishu",
                "continent" => "Africa"
            ],
            [
                "country_code" => "SR",
                "name" => "Suriname",
                "currency_code" => "SRD",
                "population" => "492829",
                "capital" => "Paramaribo",
                "continent" => "South America"
            ],
            [
                "country_code" => "SS",
                "name" => "South Sudan",
                "currency_code" => "SSP",
                "population" => "8260490",
                "capital" => "Juba",
                "continent" => "Africa"
            ],
            [
                "country_code" => "ST",
                "name" => "São Tomé and Príncipe",
                "currency_code" => "STD",
                "population" => "175808",
                "capital" => "São Tomé",
                "continent" => "Africa"
            ],
            [
                "country_code" => "SV",
                "name" => "El Salvador",
                "currency_code" => "USD",
                "population" => "6052064",
                "capital" => "San Salvador",
                "continent" => "North America"
            ],
            [
                "country_code" => "SX",
                "name" => "Sint Maarten",
                "currency_code" => "ANG",
                "population" => "37429",
                "capital" => "Philipsburg",
                "continent" => "North America"
            ],
            [
                "country_code" => "SY",
                "name" => "Syria",
                "currency_code" => "SYP",
                "population" => "22198110",
                "capital" => "Damascus",
                "continent" => "Asia"
            ],
            [
                "country_code" => "SZ",
                "name" => "Swaziland",
                "currency_code" => "SZL",
                "population" => "1354051",
                "capital" => "Mbabane",
                "continent" => "Africa"
            ],
            [
                "country_code" => "TC",
                "name" => "Turks and Caicos Islands",
                "currency_code" => "USD",
                "population" => "20556",
                "capital" => "Cockburn Town",
                "continent" => "North America"
            ],
            [
                "country_code" => "TD",
                "name" => "Chad",
                "currency_code" => "XAF",
                "population" => "10543464",
                "capital" => "N'Djamena",
                "continent" => "Africa"
            ],
            [
                "country_code" => "TF",
                "name" => "French Southern Territories",
                "currency_code" => "EUR",
                "population" => "140",
                "capital" => "Port-aux-Français",
                "continent" => "Antarctica"
            ],
            [
                "country_code" => "TG",
                "name" => "Togo",
                "currency_code" => "XOF",
                "population" => "6587239",
                "capital" => "Lomé",
                "continent" => "Africa"
            ],
            [
                "country_code" => "TH",
                "name" => "Thailand",
                "currency_code" => "THB",
                "population" => "67089500",
                "capital" => "Bangkok",
                "continent" => "Asia"
            ],
            [
                "country_code" => "TJ",
                "name" => "Tajikistan",
                "currency_code" => "TJS",
                "population" => "7487489",
                "capital" => "Dushanbe",
                "continent" => "Asia"
            ],
            [
                "country_code" => "TK",
                "name" => "Tokelau",
                "currency_code" => "NZD",
                "population" => "1466",
                "capital" => "",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "TL",
                "name" => "East Timor",
                "currency_code" => "USD",
                "population" => "1154625",
                "capital" => "Dili",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "TM",
                "name" => "Turkmenistan",
                "currency_code" => "TMT",
                "population" => "4940916",
                "capital" => "Ashgabat",
                "continent" => "Asia"
            ],
            [
                "country_code" => "TN",
                "name" => "Tunisia",
                "currency_code" => "TND",
                "population" => "10589025",
                "capital" => "Tunis",
                "continent" => "Africa"
            ],
            [
                "country_code" => "TO",
                "name" => "Tonga",
                "currency_code" => "TOP",
                "population" => "122580",
                "capital" => "Nuku'alofa",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "TR",
                "name" => "Turkey",
                "currency_code" => "TRY",
                "population" => "77804122",
                "capital" => "Ankara",
                "continent" => "Asia"
            ],
            [
                "country_code" => "TT",
                "name" => "Trinidad and Tobago",
                "currency_code" => "TTD",
                "population" => "1228691",
                "capital" => "Port of Spain",
                "continent" => "North America"
            ],
            [
                "country_code" => "TV",
                "name" => "Tuvalu",
                "currency_code" => "AUD",
                "population" => "10472",
                "capital" => "Funafuti",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "TW",
                "name" => "Taiwan",
                "currency_code" => "TWD",
                "population" => "22894384",
                "capital" => "Taipei",
                "continent" => "Asia"
            ],
            [
                "country_code" => "TZ",
                "name" => "Tanzania",
                "currency_code" => "TZS",
                "population" => "41892895",
                "capital" => "Dodoma",
                "continent" => "Africa"
            ],
            [
                "country_code" => "UA",
                "name" => "Ukraine",
                "currency_code" => "UAH",
                "population" => "45415596",
                "capital" => "Kiev",
                "continent" => "Europe"
            ],
            [
                "country_code" => "UG",
                "name" => "Uganda",
                "currency_code" => "UGX",
                "population" => "33398682",
                "capital" => "Kampala",
                "continent" => "Africa"
            ],
            [
                "country_code" => "UM",
                "name" => "U.S. Minor Outlying Islands",
                "currency_code" => "USD",
                "population" => "0",
                "capital" => "",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "US",
                "name" => "United States",
                "currency_code" => "USD",
                "population" => "310232863",
                "capital" => "Washington",
                "continent" => "North America"
            ],
            [
                "country_code" => "UY",
                "name" => "Uruguay",
                "currency_code" => "UYU",
                "population" => "3477000",
                "capital" => "Montevideo",
                "continent" => "South America"
            ],
            [
                "country_code" => "UZ",
                "name" => "Uzbekistan",
                "currency_code" => "UZS",
                "population" => "27865738",
                "capital" => "Tashkent",
                "continent" => "Asia"
            ],
            [
                "country_code" => "VA",
                "name" => "Vatican City",
                "currency_code" => "EUR",
                "population" => "921",
                "capital" => "Vatican City",
                "continent" => "Europe"
            ],
            [
                "country_code" => "VC",
                "name" => "Saint Vincent and the Grenadines",
                "currency_code" => "XCD",
                "population" => "104217",
                "capital" => "Kingstown",
                "continent" => "North America"
            ],
            [
                "country_code" => "VE",
                "name" => "Venezuela",
                "currency_code" => "VEF",
                "population" => "27223228",
                "capital" => "Caracas",
                "continent" => "South America"
            ],
            [
                "country_code" => "VG",
                "name" => "British Virgin Islands",
                "currency_code" => "USD",
                "population" => "21730",
                "capital" => "Road Town",
                "continent" => "North America"
            ],
            [
                "country_code" => "VI",
                "name" => "U.S. Virgin Islands",
                "currency_code" => "USD",
                "population" => "108708",
                "capital" => "Charlotte Amalie",
                "continent" => "North America"
            ],
            [
                "country_code" => "VN",
                "name" => "Vietnam",
                "currency_code" => "VND",
                "population" => "89571130",
                "capital" => "Hanoi",
                "continent" => "Asia"
            ],
            [
                "country_code" => "VU",
                "name" => "Vanuatu",
                "currency_code" => "VUV",
                "population" => "221552",
                "capital" => "Port Vila",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "WF",
                "name" => "Wallis and Futuna",
                "currency_code" => "XPF",
                "population" => "16025",
                "capital" => "Mata-Utu",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "WS",
                "name" => "Samoa",
                "currency_code" => "WST",
                "population" => "192001",
                "capital" => "Apia",
                "continent" => "Oceania"
            ],
            [
                "country_code" => "XK",
                "name" => "Kosovo",
                "currency_code" => "EUR",
                "population" => "1800000",
                "capital" => "Pristina",
                "continent" => "Europe"
            ],
            [
                "country_code" => "YE",
                "name" => "Yemen",
                "currency_code" => "YER",
                "population" => "23495361",
                "capital" => "Sanaa",
                "continent" => "Asia"
            ],
            [
                "country_code" => "YT",
                "name" => "Mayotte",
                "currency_code" => "EUR",
                "population" => "159042",
                "capital" => "Mamoudzou",
                "continent" => "Africa"
            ],
            [
                "country_code" => "ZA",
                "name" => "South Africa",
                "currency_code" => "ZAR",
                "population" => "49000000",
                "capital" => "Pretoria",
                "continent" => "Africa"
            ],
            [
                "country_code" => "ZM",
                "name" => "Zambia",
                "currency_code" => "ZMW",
                "population" => "13460305",
                "capital" => "Lusaka",
                "continent" => "Africa"
            ],
            [
                "country_code" => "ZW",
                "name" => "Zimbabwe",
                "currency_code" => "ZWL",
                "population" => "13061000",
                "capital" => "Harare",
                "continent" => "Africa"
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};