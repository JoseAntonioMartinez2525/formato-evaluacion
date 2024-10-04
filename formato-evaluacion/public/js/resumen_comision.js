 function evaluarCalidad(total)
    {
        switch (true) {
            case (total >= 210 && total <= 264):
                return 'I';
            case (total >= 265 && total <= 319):
                return 'II';
            case (total >= 320 && total <= 374):
                return 'III';
            case (total >= 375 && total <= 429):
                return 'IV';
            case (total >= 430 && total <= 484):
                return 'V';
            case (total >= 485 && total <= 539):
                return 'VI';
            case (total >= 540 && total <= 594):
                return 'VII';
            case (total >= 595 && total <= 649):
                return 'FALSE';
            default:
                return 'FALSE';
        }
    }

    // Función para evaluar el total
    function evaluarTotal(totalComisionRepetido)
    {
        switch (true) {
            case (totalComisionRepetido >= 301 && totalComisionRepetido <= 377):
                return 'I';
            case (totalComisionRepetido >= 378 && totalComisionRepetido <= 455):
                return 'II';
            case (totalComisionRepetido >= 456 && totalComisionRepetido <= 533):
                return 'III';
            case (totalComisionRepetido >= 534 && totalComisionRepetido <= 611):
                return 'IV';
            case (totalComisionRepetido >= 612 && totalComisionRepetido <= 689):
                return 'V';
            case (totalComisionRepetido >= 690 && totalComisionRepetido <= 767):
                return 'VI';
            case (totalComisionRepetido >= 768 && totalComisionRepetido <= 845):
                return 'VII';
            case (totalComisionRepetido >= 846 && totalComisionRepetido <= 923):
                return 'VIII';
            case (totalComisionRepetido >= 924 && totalComisionRepetido <= 1000):
                return 'IX';
            default:
                return 'FALSE';
        }
    }