@extends('dashboard')
@section('content')
    <div class="container">
        <div id="table_view">
            <div class="table">
                <thead>
                    <tr>
                        <th>Titolo</th>
                        <th>Descrizione</th>
                        <th>Indirizzo</th>
                        <th>Citta</th>
                        <th>Copertina</th>
                        <th>Prezzo</th>
                        <th>Stanze</th>
                        <th>Camere</th>
                        <th>Bagni</th>
                        <th>Superficie</th>
                        <th>Tipo</th>
                        <th>Disponibilità</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($realEstates as $realEstate)
                        <tr>
                            <td>{{ $realEstate->title }}</td>
                            <td>{{ $realEstate->description }}</td>
                            <td>{{ $realEstate->address }}</td>
                            <td>{{ $realEstate->city }}</td>
                            <td>{{ $realEstate->portrait }}</td>
                            <td>{{ $realEstate->price }}</td>
                            <td>{{ $realEstate->rooms }}</td>
                            <td>{{ $realEstate->beds }}</td>
                            <td>{{ $realEstate->bathrooms }}</td>
                            <td>{{ $realEstate->square_meter }}</td>
                            <td>{{ $realEstate->structure_types }}</td>
                            <td>{{ $realEstate->avilability }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </div>
        </div>
    </div>
@endsection
