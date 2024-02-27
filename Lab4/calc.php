<?php

function calculate($expression) {
    $expression = str_replace(' ', '', $expression);

    if (!preg_match('/^[\d\+\-\*\/\(\)]+$/', $expression)) {
        return 'Символы в выражении.';
    }

    if (preg_match('/\/\d*0/', $expression)) {
        return 'Error [0]';
    }

    try {
        $result = evaluateExpression($expression);
        return $result;
    } catch (Throwable $e) {
        return 'Ошибка при вычислении выражения: ' . $e->getMessage();
    }
}

function evaluateExpression($expression) {
    $operators = ['+', '-', '*', '/'];
    $operands = [];
    $operatorsStack = [];

    $tokens = str_split($expression);
    $currentNumber = '';

    foreach ($tokens as $token) {
        if (is_numeric($token) || $token == '.') {
            $currentNumber .= $token;
        } elseif ($token == '(') {
            $operatorsStack[] = $token;
        } elseif ($token == ')') {
            while (!empty($operatorsStack) && end($operatorsStack) !== '(') {
                $operands[] = array_pop($operatorsStack);
            }
            array_pop($operatorsStack);
        } elseif (in_array($token, $operators)) {
            if ($currentNumber !== '') {
                $operands[] = (float)$currentNumber;
                $currentNumber = '';
            }

            while (!empty($operatorsStack) && isOperatorGreaterOrEqual($token, end($operatorsStack))) {
                $operands[] = array_pop($operatorsStack);
            }
            $operatorsStack[] = $token;
        }
    }

    if ($currentNumber !== '') {
        $operands[] = (float)$currentNumber;
    }

    while (!empty($operatorsStack)) {
        $operands[] = array_pop($operatorsStack);
    }

    $resultStack = [];
    foreach ($operands as $token) {
        if (is_numeric($token)) {
            $resultStack[] = $token;
        } elseif (in_array($token, $operators)) {
            $operand2 = array_pop($resultStack);
            $operand1 = array_pop($resultStack);
            $resultStack[] = applyOperator($token, $operand1, $operand2);
        }
    }

    return reset($resultStack);
}

function isOperatorGreaterOrEqual($op1, $op2) {
    $operatorPriority = [
        '+' => 1,
        '-' => 1,
        '*' => 2,
        '/' => 2,
    ];

    return ($operatorPriority[$op1] >= $operatorPriority[$op2]);
}

function applyOperator($operator, $operand1, $operand2) {
    switch ($operator) {
        case '+':
            return $operand1 + $operand2;
        case '-':
            return $operand1 - $operand2;
        case '*':
            return $operand1 * $operand2;
        case '/':
            if ($operand2 == 0) {
                throw new Exception('Деление на 0');
            }
            return $operand1 / $operand2;
        default:
            throw new Exception('Невыбран оператор');
    }
}

if (isset($_GET['expression'])) {
    $userExpression = $_GET['expression'];
    $result = calculate($userExpression);
    echo json_encode(['result' => $result]);
} else {
    echo json_encode(['error' => 'Отсутствует выражение для вычисления.']);
}
?>
