<style>
    #body-history{
        height: 500px;
        overflow:hidden;
    }
    #body-history:hover{overflow-y:auto;}
</style>

<div id="historyOrder" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Historial</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="body-history" >
           <div class="col-xl-12 col-lg-12">
               {{-- border-left-success  para paquetes activos que aun no usa--}}
               {{-- border-left-danger para paquetes que ya se usaron --}}
                <div class="card shadow mb-4 border-left">
                    <div class="card-header py-2">
                        <div class="row">
                            <h6 class="m-0 font-weight-bold">Historial de paquetes</h6>
                        </div>
                    </div>
                    @if ($user->ActivePackage != NULL)
                    <hr>
                    @foreach ($user->ActivePackage as $info)
                    @if($info != $user->ActivePackage->first())
                    <div class="col-lg-12">
                        <div class="card shadow mb-4 border-left-success">
                            <div class="card-header py-2">
                                <div class="row">
                                    <div class="col-10">
                                        <h6 class="m-0 font-weight-bold">{{$info->paquete->name}}</h6>
                                    </div>
                                    <div class="col-2 float-right">
                                        #{{$info->id}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <input type="hidden" id="id_paquete">
                                <h6>
                                <strong>TOTAL DE HORAS:</strong> {{$info->paquete->total_hours}}
                                </h6>
                            </div>
                            @if ($info->benefit != NULL)
                            <div class="card-body">
                                <h6><strong>BENEFICIO DE LA ORDEN: </strong>{{$info->benefit->name}} </h6>
                                <h6><strong>DESCRIPCIÓN DEL BENEFICIO: </strong> {{$info->benefit->description}}</h6>
                                <h6><strong>FECHA DE EXPIRACIÓN DEL BENEFICIO: </strong> {{$info->benefit->validity}}</h6>
                            </div>
                            @else
                            <div class="card-body">
                                <h6><strong>ESTE PAQUETE NO CUENTA CON BENEFICIO</strong></h6>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endif
                    <hr>
                    @foreach ($user->FinishedPackages as $info)
                    <div class="col-lg-12">
                        <div class="card shadow mb-4 border-left-danger">
                            <div class="card-header py-2">
                                <div class="row">
                                    <div class="col-10">
                                        <h6 class="m-0 font-weight-bold">{{$info->paquete->name}}</h6>
                                    </div>
                                    <div class="col-2 float-right">
                                        #{{$info->id}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <input type="hidden" id="id_paquete">
                                <h6>
                                <strong>TOTAL DE HORAS:</strong> {{$info->paquete->total_hours}}
                                </h6>
                            </div>
                            @if ($info->benefit != NULL)
                            <div class="card-body">
                                <h6><strong>BENEFICIO DE LA ORDEN: </strong>{{$info->benefit->name}} </h6>
                                <h6><strong>DESCRIPCIÓN DEL BENEFICIO: </strong> {{$info->benefit->description}}</h6>
                                <h6><strong>FECHA DE EXPIRACIÓN DEL BENEFICIO: </strong> {{$info->benefit->validity}}</h6>
                            </div>
                            @else
                            <div class="card-body">
                                <h6><strong>ESTE PAQUETE NO CUENTA CON BENEFICIO</strong></h6>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

