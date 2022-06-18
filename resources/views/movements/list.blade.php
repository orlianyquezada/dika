<h1>hola</h1>
@foreach($customers as $customer)
    <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
@endforeach