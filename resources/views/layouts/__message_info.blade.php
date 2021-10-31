@if (session('success'))
<div class="alert alert-success alert-dismissable fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissable fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (session('sales_exp') || @isset($sales_exp))
<div class="alert alert-info alert-dismissable fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
   Una vez agregadas las explosiones de venta, es necesario presionar el botón sincronizar,
    a su vez que si hay cambio de fecha en algún documento relacionado con dichas explosiones.
</div>
@endif