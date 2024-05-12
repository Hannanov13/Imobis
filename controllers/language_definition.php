<?php



function search_language($string)
{
    $en = [];
    $ru = [];

    for ($i = 0; $i < mb_strlen($string); $i++) {
        $symbol_code = mb_ord(mb_substr($string, $i, 1, 'UTF-8'));


        if ((1040 <= $symbol_code and $symbol_code <= 1103) or $symbol_code == 1025 || $symbol_code == 1105) {
            $ru[] = $i;
        } elseif ((65 <= $symbol_code and $symbol_code <= 90) or (97 <= $symbol_code && $symbol_code <= 122)) {
            $en[] = $i;
        }
    }

    return ['ru' => $ru, 'en' => $en];
}

$string = $_POST['string'];

echo json_encode(search_language($string));