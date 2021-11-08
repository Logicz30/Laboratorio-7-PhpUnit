<?php
require_once (__DIR__.'/Calculadora.php');
use PHPUnit\Framework\TestCase;

class CalculadoraTest extends TestCase
{
    public function SumarProveedor()
    {
        return [
            'Caso 1' => [-1, -1, -2],
            'Caso 2' => [0, 0, 0],
            'Caso 3' => [0, -1, -1],
            'Caso 4' => [-1, 0, -1]
        ];
    }

    /**
     * @dataProvider SumarProveedor
     */

    public function testSumar($numero1, $numero2, $resultado_esperado)
    {
        $calculadora = new Calculadora();
        //$this->assertEquals("6",  $calculadora->sumar(3,3));
        $this->assertEquals($resultado_esperado, $calculadora->sumar($numero1,$numero2));
    }

    public function RestarProveedor()
    {
        return [
            'Caso 1' => [-1, -1, 0],
            'Caso 2' => [0, 0, 0],
            'Caso 3' => [0, -1, 1],
            'Caso 4' => [-1, 0, -1]
        ];
    }

    /**
     * @dataProvider RestarProveedor
     */

    public function testRestar($numero1, $numero2, $resultado_esperado)
    {
        $calculadora = new Calculadora();
        $this->assertEquals($resultado_esperado, $calculadora->restar($numero1,$numero2));
    }

    public function MultiplicarProveedor()
    {
        return [
            'Caso 1' => [-1, -1, 1],
            'Caso 2' => [0, 0, 0],
            'Caso 3' => [2, 3, 6],
            'Caso 4' => [-5, 2, -10]
        ];
    }

    /**
     * @dataProvider MultiplicarProveedor
     */

    public function testMultiplicar($numero1, $numero2, $resultado_esperado)
    {
        $calculadora = new Calculadora();
        $this->assertEquals($resultado_esperado, $calculadora->multiplicar($numero1,$numero2));
    }

    public function DividirProveedor()
    {
        return [
            'Caso 1' => [-1, -1,  1, 0],
            'Caso 2' => [0, 0, "Exception", ""],
            'Caso 3' => [0, -1, 0, 0],
            'Caso 4' => [-1, 0, "Exception", ""],
            'Caso 5' => [1, 3, 0.33, 0.01]
        ];
    }

    /**
     * @dataProvider DividirProveedor
     */

    public function testDividir($numero1, $numero2, $resultado_esperado, $delta)
    {
        $calculadora = new Calculadora();
        if ($numero2 != 0){
            $this->assertEqualsWithDelta($resultado_esperado, $calculadora->dividir($numero1,$numero2), $delta);
        } else{
            $this->expectException('Exception');
            $calculadora->dividir($numero1, $numero2);
        }
    }

    public function testGenerarArreglo()
    {
        $calculadora = new Calculadora();
        //$this->assertContains(7, $calculadora->generarArreglo());
        //$this->assertCount(5, $calculadora->generarArreglo());
        $this->assertNotEmpty( $calculadora->generarArreglo());
    }

    public function TestCapturarEntradasPermutacion()
    {
        //se crea el doble de prueba para la clase Calculadora, metodo 'Capturar entradas permutazcion'
        $stub = $this->createMock('Calculadora');
        $stub->method('CapturarEntradasPermutacion')->willReturn(array(5,3));

        $this->assertSame(array(5,3),$stub->capturarEntradasPermutacion());

    }

    public function testCalcularPermutacion()
    {
        /*Se crea un mock para la clase calculadora.
        Solo se hace al metodo calcularFactorial*/
        $mock = $this->getMockBuilder('Calculadora')
            ->onlyMethods(array('CalcularFactorial'))
            ->getMock();

        /*Se configuran las expectativas para el metodo calcularFactorial.
        Se llamara 2 veces y devolvera 120 y 6, en cada ocasion, respectivamente. */
        $mock->expects($this->exactly(2))
            ->method('calcularFactorial')
            ->will($this->onConsecutiveCalls(120, 6));

        /*Se hace assert. */
        $this->assertSame(20, $mock->calcularPermutacion(5, 2));
    }

    public function testComprobarLlamada()
    {
        $mock = $this->getMockBuilder('Calculadora')
            ->onlyMethods(array('CalcularFactorial'))
            ->getMock();
       /*
        $mock->expects($this->exactly(2))
            ->method('calcularFactorial')
            ->withConsecutive([5], [3]);

        $mock->calcularFactorial(5);
        $mock->calcularFactorial(4);
       */

       /* $mock->expects($this->once())
            ->method ('calcularFactorial')
            ->with(5)
            ->will($this->returnValue(120));
        $resultado_calculado = $mock ->calcularFactorial(5);
        $this ->assertEquals(120, $resultado_calculado);
        $mock->calcularFactorial(3);
        $this ->assertEquals(121, $resultado_calculado);*/
        $mock->expects($this->exactly(2))
            ->method('calcularFactorial')
            ->withConsecutive([5], [3])
            ->will($this->onConsecutiveCalls(120,6));
        $this->assertEquals(120, $mock->calcularFactorial(5));
        $this->assertEquals(6, $mock->calcularFactorial(3));
    }
}
