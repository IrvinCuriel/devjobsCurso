@extends ('layouts.app')

@section('navegacion')
  @include('ui.categoriasnav')
@endsection

@section('content')

  @if(count($vacantes) > 0)
  <div class="my-10 bg-gray-100 p-10 shadow">
    <h1 class="text-3xl text-gray-700 m-0">
      {{ count($vacantes) }} RESULTADOS
      <span class="font-bold">ENCOTRADOS: </span>
    </h1>

<!-- se crea un parcial y se coloca en UI listadovacantes que se usara tambien en index.blade de inicio y Show.blade.php de categorias-->
<!--
    <ul class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
      @foreach($vacantes as $vacante)
        <li class="p-10 border border-gray-300 bg-white shadow">
          <h2 class="text-2xl font-bold text-teal-700">{{ $vacante->titulo }}</h2>
          <p class="block text-gray-700 font-normal my-2">
            {{ $vacante->categoria->nombre }}
          </p>
          <p class="block text-gray-700 font-normal my-2">
            Ubicación:
            <span class="font-bold">{{ $vacante->ubicacion->nombre }}</span>
          </p>
          <p class="block text-gray-700 font-normal my-2">
            Experiencia:
            <span class="font-bold">{{ $vacante->experiencia->nombre }}</span>
          </p>
          <a  class="bg-teal-500 text-gray-100 mt-2 px-4 py-2 inline-block rounded font-bold text-sm" href="{{ route('vacantes.show', ['vacante' => $vacante->id]) }}">
            Ver Vacante
          </a>
        </li>
      @endforeach
    </ul>
-->
    @include('ui.listadovacantes')

  </div>

  @else
  <div class="my-10 bg-gray-100 p-10 shadow">
    <h1 class="text-3xl text-gray-700 m-0">
      NO SE ENCOTRO
      <span class="font-bold">RESULTADOS </span>
    </h1>

<!-- se crea un parcial y se coloca en UI listadovacantes que se usara tambien en index.blade de inicio y Show.blade.php de categorias-->
<!--
    <ul class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
      @foreach($vacantes as $vacante)
        <li class="p-10 border border-gray-300 bg-white shadow">
          <h2 class="text-2xl font-bold text-teal-700">{{ $vacante->titulo }}</h2>
          <p class="block text-gray-700 font-normal my-2">
            {{ $vacante->categoria->nombre }}
          </p>
          <p class="block text-gray-700 font-normal my-2">
            Ubicación:
            <span class="font-bold">{{ $vacante->ubicacion->nombre }}</span>
          </p>
          <p class="block text-gray-700 font-normal my-2">
            Experiencia:
            <span class="font-bold">{{ $vacante->experiencia->nombre }}</span>
          </p>
          <a  class="bg-teal-500 text-gray-100 mt-2 px-4 py-2 inline-block rounded font-bold text-sm" href="{{ route('vacantes.show', ['vacante' => $vacante->id]) }}">
            Ver Vacante
          </a>
        </li>
      @endforeach
    </ul>
-->
    @include('ui.listadovacantes')
  </div>

  @endif

@endsection
