# Problema de código en Foris 
## SELECCIÓN DE PARADIGMA DE PROGRAMACIÓN

En un principio pensé en utilizar paradigma de programación estructurada, ya que al ser un problema relativamente pequeño, y con un objetivo claro, se puede dividir el código en pequeñas funciones que lo hacen bastante legible y sencillo. Al ir organizando la estructura del proyecto, me di cuenta que habían ciertos componentes que podían transformarse a Clases, para hacer su interacción más intuitiva y escalable, a demás del dato del número de sala; éste me hizo pensar que el problema planteado puede ser sólo una primera entrega de un proyecto más grande, o bien, un módulo de un proyecto que también utilizará el dato de la sala para sacar reportes. Por esta razón se decidió orientar a objetos, para que los métodos de las clases sean accesibles y re utilizables desde otros módulos.


## SOBRE EL CÓDIGO 

Ejecutar con `php reporte.php example.txt`, se puede seleccionar otro archivo, utilizando la ruta relativa a la ruta de `reporte.php`.

El código verifica si se pasa como parámetro algun archivo, verifica que exista, y que su tamaño no exceda los 2Mb.
Si pasa esas validaciones, abre el archivo y lo convierte en un array, luego se comienza a trabajar con las posiciones de ese array.

Si el índice 0 del array de una linea, es Student, entonces el código intentará agregar el nuevo estudiante a un array de estudiantes, si es que no existe previamente. Si el indice 0 es Presence, el código intenta buscar si existe el estudiante en el array de estudiantes, si existe, continúa con el proceso. Si el estudiante no existe, lo crea y continúa con el proceso. Esta decisión se tomó para solventar el problema que se puede generar si hay un Registro Presence del estudiante Pepito, antes que haya un registro `Student Pepito`, de lo contrario, ese registro se perdería.

Siguiendo con el proceso, se toma el día de asistencia y se agrega a un array de días que asiste, este registro se agrega sólo si no existe en el array de días, para saber con exactitud la cantidad de días que asistió. Luego continúa con el cálculo de los minutos asistidos, verifica que el dato de inicio sea menor al dato final, y que la presencia haya sido mayor a 5 minutos, de lo contrario no se agrega ni el día al array de días, ni se suman los minutos al pool de minutos del estudiante.

> Se decidió no omitir las presencias de los días Domingo

Hasta aquí, Una linea `Presence David 5 14:00 15:05 F505` generaría un registro 
```
[
    "name" => "David",
    "minutes" => 65,
    "days" => [5]
]
```

Luego de iterar por todas las lineas del archivo, e ir sumando los minutos válidos de cada Estudiante, y haber añadido los días al array de días, se procede al ordenado del array. Una vez ordenados, se imprimen por consola con el formato requerido.