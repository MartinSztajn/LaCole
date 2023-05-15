<h2>Gracias Por haber hecho una Compra en Metro de Tela</h2>


<h4>Conocé los detalles de la orden</h4>

<h4>Orden Nro: #{{$pedido->id}}</h4>

@if($pedido->metodoPago == 0)
    <div style="color: red"><?php echo $cbu->cuentaBancaria; ?></div>
@endif


    <b>Información de Envío</b>
@if($pedido->costoEnvio != null)
    <p>Domicilio
        Calle: {{$cliente->direccion}}<br>
        Numero: {{$cliente->numero}}<br>
        Piso: {{$cliente->piso}}
        Departamento: {{$cliente->departamento}}
        Localidad: {{$cliente->localidad}}
        Cuidad: {{$cliente->cuidad}}
        Provincia: {{$cliente->provincia}}

        Costo de Envio: {{$pedido->CostoEnvio}}
    </p>

@else
    <p>Pasa por el Deposito</p>
    @endif
    </p>
    <b>Información de Pago</b>
    @if($pedido->metodoPago == 0)
        <p>
            Pago en Efectivo o Transferencia
        </p>
    @else
        <p>Mercado Pago<br>
            Codigo de Seguimiento: {{$pedido->idMercado}} </p>
    @endif
    <b>Estado de Pago</b>
    @if($pedido->estadoPago == 0)
        <p>Pendiente</p>
    @elseif($pedido->estadoPago == 1)
        <p>Pagado</p>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Nombre</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
            <th scope="col">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pedidoDetalle as $ped)
            <tr>
                <th></th>
                <th>{{$ped->nombre}}</th>
                <td>{{$ped->cantidad}}</td>
                <td>${{$ped->precio}}</td>
                <td>{{($ped->precio * $ped->cantidad )}}</td>
            </tr>
        @endforeach
        <tr>
            <th></th>
            <th>Envio</th>
            <td></td>
            <td></td>
            <td>{{$pedido->costoEnvio}}</td>
        </tr>
        @if($pedido->descuento != 0)
            <tr>
                <th></th>
                <th>Descuento</th>
                <td></td>
                <td></td>
                <td>{{$pedido->descuento}}</td>
            </tr>
        @endif
        <tr>
            <th></th>
            <th>Total</th>
            <td></td>
            <td></td>
            <td>{{$pedido->total}}</td>
        </tr>
        </tbody>
    </table>
    <h3>Pedido: {{$pedido->total}}</h3>


