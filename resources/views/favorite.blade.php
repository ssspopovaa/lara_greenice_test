@extends('layouts.layout')

@section('content')
<h3>Список избранных репозиториев</h3>
<div class="list-group">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">HTML_URL</th>
          <th scope="col">Description</th>
          <th scope="col">Owner.Login</th>
          <th scope="col">Stargazers_Count</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
         @if (isset($repos) && count($repos) > 0)
            @foreach ($repos as $rep)  
                <tr>      
                    <td>{{ $rep->name }}</td>
                    <td><a href="{{ $rep->html_url}} "> {{ $rep->html_url }} </a></td>
                    <td>{{ $rep->description }}</td>
                    <td>{{ $rep->owner_login }}</td>
                    <td>{{ $rep->stargazers_count }}</td>
                    <td>
                        <a href="delete/{{ $rep->id }}">
                            <button>Удалить</button>
                        </a>
                    </td>
                </tr>
            @endforeach
          @else
            <h2>В избранных нет сохраненных репозиториев.</h2>
          @endif  
      </tbody>
    </table>
    {{ $repos->links() }}
</div>

@endsection