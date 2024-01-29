@extends('layout')
@section('content')

<style>
    .card {
        border: 0; /* Set border to 0 */
    }
</style>

<br>
<div class="container">
    <h1>Search Results for "{{ $searchQuery }}"</h1>

    @if ($products->isEmpty())
        <p>No results found.</p>
    @else
        <ul>
            <br>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="card d-flex flex-column" style="height: 100%;">
                            <form class="form-inline my-2 my-lg-0" action="{{ route('allProduct', ['id' => $product->id]) }}" method="GET">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <img src="{{ asset('images') }}/{{ $product->image }}" alt="{{ $product->name }}" class="card-img-top">
                                    <p class="card-text">RM {{ $product->price }}</p>
                                    <button class="btn btn-danger btn-xs" type="submit">Add to Cart</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                @endforeach
            </div>
        </ul>
    @endif
</div>
@endsection
