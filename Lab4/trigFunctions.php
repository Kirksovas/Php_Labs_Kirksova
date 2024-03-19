<?php
function degreesToRadians($degrees) {
    return deg2rad($degrees);
}

function radiansToDegrees($radians) {
    return rad2deg($radians);
}


function calculateTrigonometric($function_name, $degrees) {
    // Преобразуем градусы в радианы
    $radians = degreesToRadians($degrees);

    switch ($function_name) {
        case 'sin':
            $result = sin($radians);
            break;
        case 'cos':
            $result = cos($radians);
            break;
        case 'tan':
            $result = tan($radians);
            break;
        default:
            return "Unsupported trigonometric function.";
    }

    return $result; 
}

?>
