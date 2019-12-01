<?php

$file = file_get_contents('input-day5.txt');


foreach(explode(' ', "a b c d e f g h i j k l m n o p q r s t u v w x y z") as $p) {
    $output = '';

    $input = str_ireplace($p, '', $file);

    $length = strlen($input) - 1;
    $output_pos = -1;
    $reduce_count = [];

    for($input_pos = 0; $input_pos < $length; $input_pos++) {
        $char = $input[$input_pos];
        if($output_pos < 0 ) {
            $output = $char;
            $output_pos = 0;
            continue;
        }

        $char_output = $output[$output_pos];
        if($char != $char_output && strtoupper($char) === strtoupper($char_output)) {
            $output_pos--;
            $output = substr($output, 0, -1);
            continue;
        }
        
        $output_pos++;
        $output .= $char;
    }


    $lengths[$p] = strlen($output);
}

asort($lengths);
print array_shift($lengths);