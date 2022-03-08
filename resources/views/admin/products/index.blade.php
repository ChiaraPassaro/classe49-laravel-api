@extends('layouts.admin')

@section('script')
    <script src="{{ asset('js/admin.js') }}" defer></script>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Tags</th>
                        <th>Price</th>
                        <th colspan="3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>
                                @foreach ($product->tags()->get() as $tag)
                                    {{ $tag->name }}
                                @endforeach
                            </td>
                            <td>{{ $product->price }}</td>
                            <td><a class="btn btn-info" href="{{ route('admin.products.show', $product) }}">View</a></td>
                            <td><a class="btn btn-primary" href="{{ route('admin.products.edit', $product) }}">View</a>
                            </td>
                            <td>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" value="Delete">
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <h2>Non ci sono prodotti</h2>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
@endsection
