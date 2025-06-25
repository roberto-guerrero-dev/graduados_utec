var oRegEx = {
    cicloRegEx: function getDynamicYearRegex() {
        const currentYear = new Date().getFullYear(); // Obtiene el año actual (ej: 2025)
        const currentYearString = currentYear.toString(); // Convierte el año a cadena

        // Parte para años del 1980 al 1999
        const pastYearsPattern = `19(?:8[0-9]|9[0-9])`;

        // Parte para años del 2000 hasta el año actual
        let currentCenturyPattern;
        if (currentYear >= 2000) {
            const lastTwoDigitsCurrentYear = parseInt(
                currentYearString.substring(2)
            ); // ej: 25 para 2025

            // Si el año actual es, por ejemplo, 2025:
            // [01][0-9] cubre 2000-2019
            // 2[0-5] cubre 2020-2025
            // Esto se traduce a '20(?:[01][0-9]|2[0-5])'
            let dynamicEndRange = "";
            if (lastTwoDigitsCurrentYear < 10) {
                // Si el año actual es 2000-2009
                dynamicEndRange = `0[0-${lastTwoDigitsCurrentYear}]`;
            } else if (lastTwoDigitsCurrentYear < 20) {
                // Si el año actual es 2010-2019
                dynamicEndRange = `[01][0-9]`;
            } else {
                // Si el año actual es 2020 o más
                // Construye la parte para el rango del 2000 al 2019 ([01][0-9])
                let firstPart = "";
                if (lastTwoDigitsCurrentYear >= 20) {
                    firstPart = "[01][0-9]";
                }

                // Construye la parte para el rango desde 2020 hasta el año actual
                // ej: para 2025, sería 2[0-5]
                const secondDigitLimit = currentYearString[3]; // Segundo dígito del año actual (ej: '5' para 2025)
                const thirdDigitLimit = currentYearString[2]; // Primer dígito del año actual (ej: '2' para 2025)

                let currentDecadePattern = `${thirdDigitLimit}[0-${secondDigitLimit}]`;

                currentCenturyPattern = `20(?:${
                    firstPart ? firstPart + "|" : ""
                }${currentDecadePattern})`;
            }
        } else {
            // Esto manejaría años fuera del siglo XXI, pero para este caso no es necesario
            // ya que el rango mínimo es 1980.
            currentCenturyPattern = "";
        }

        // Combina todas las partes
        // El patrón final para los años será: (1980-1999 | 2000-AñoActual)
        const yearPattern = `(${pastYearsPattern}|${currentCenturyPattern})`;

        // La expresión regular completa
        // const fullRegexString = `^(01|02|03)-${yearPattern}$`; // Esto estaba dando problemas si el firstPart estaba vacío
        const fullRegexString = `^(01|02|03)-${pastYearsPattern}|^(01|02|03)-${currentCenturyPattern}$`;

        // Asegúrate de que solo la última parte de la ER sea opcional si no hay coincidencia
        // del primer patrón. Es más sencillo construirlo así:
        const finalRegexString = `^(01|02|03)-(${pastYearsPattern}|${currentCenturyPattern})$`;

        return new RegExp(finalRegexString);
    },
};
