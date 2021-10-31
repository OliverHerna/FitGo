<div id="createOrder" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear Orden </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    @if($viewId != 1)
                    <div class="form-group col-lg-4">
                        <label for=""><span>*</span>Folio</label>
                        <input type="text" class="form-control {{ !$errors->has('folio') ?: 'is-invalid' }}" name="folio" value="{{ old('folio') }}">
                        @if ($errors->has('folio'))
                        @foreach ($errors->get('folio') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="hours"><span>*</span>Horas</label>
                        <input type="number" step=".25" min=".25" class="form-control {{ !$errors->has('hours') ?: 'is-invalid' }}" name="hours" value="{{ old('hours') }}">
                        @if ($errors->has('hours'))
                        @foreach ($errors->get('hours') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group col-lg-4" id="clientLabel">
                        <label for="user"><span>*</span>Cliente</label>
                        <select class="form-control {{ !$errors->has('user') ?: 'is-invalid' }}" name="user">
                            <option disabled selected value>Selecciona el Cliente</option>
                            @foreach ($users as $user)
                            @if ($user->ActivePackage->first() != NULL)
                            <option value="{{$user->id}}" {{ old('') != $user->id ?: 'selected' }}>{{ $user->company_name}}</option>
                            @endif
                            @endforeach
                        </select>
                        @if ($errors->has('user'))
                        @foreach ($errors->get('user') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                    @else
                    <div class="form-group col-lg-6">
                        <label for=""><span>*</span>Folio</label>
                        <input type="text" class="form-control {{ !$errors->has('folio') ?: 'is-invalid' }}" name="folio" value="{{ old('folio') }}">
                        @if ($errors->has('folio'))
                        @foreach ($errors->get('folio') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="hours"><span>*</span>Horas</label>
                        <input type="number" step=".25" min=".25" class="form-control {{ !$errors->has('hours') ?: 'is-invalid' }}" name="hours" value="{{ old('hours') }}">
                        @if ($errors->has('hours'))
                        @foreach ($errors->get('hours') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group col-lg-4" id="clientLabel" style="display: none">
                        <label for="user"><span>*</span>Cliente</label>
                        <input type="text" class="form-control {{ !$errors->has('user') ?: 'is-invalid' }}" name="user" value="{{$clientProfile->id}}">
                        @if ($errors->has('user'))
                        @foreach ($errors->get('user') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                    @endif
                    <div class="form-group col-lg-12">
                        <label for="description"><span>*</span>Descripción</label>
                        <textarea class="form-control {{ !$errors->has('description') ?: 'is-invalid' }}"  name="description"></textarea>
                        @if ($errors->has('description'))
                        @foreach ($errors->get('description') as $message)
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

