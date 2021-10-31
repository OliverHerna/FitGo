
   <div id="assignPackage" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Asignar paquete</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="{{ route('packageClient') }}" method="POST">
                  @csrf
                  <div class="form-row">
                     <div class="form-group col-lg-6">
                        <label for="paquete_user"><span>*</span>Cliente</label>
                        <select class="form-control {{ !$errors->has('client') ?: 'is-invalid' }}" name="client">
                           <option disabled selected value>Selecciona cliente</option>
                           @foreach ($clients as $client)
                           <option value="{{$client->id}}" {{ old('') != $client->id ?: 'selected' }}>{{ $client->company_name}}</option>
                           @endforeach
                        </select>
                        @if ($errors->has('paquete_user'))
                        @foreach ($errors->get('paquete_user') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                     </div>
                     <div class="form-group col-lg-6">
                        <label for="paquete_user"><span>*</span>Paquete</label>
                        <select class="form-control {{ !$errors->has('paquete_user') ?: 'is-invalid' }}" name="package">
                           <option disabled selected value>Selecciona cliente</option>
                           @foreach ($packages as $package)
                           <option value="{{$package->id}}" {{ old('') != $package->id ?: 'selected' }}>{{ $package->name}}</option>
                           @endforeach
                        </select>
                        @if ($errors->has('package'))
                        @foreach ($errors->get('package') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                     </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar</button>

               </form>
            </div>
         </div>
      </div>
   </div>
