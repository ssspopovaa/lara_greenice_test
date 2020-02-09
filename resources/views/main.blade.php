@extends('layouts.layout')

@section('content')

<div class="list-group">
     @if (isset($repos) && count($repos) > 0)
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
            @foreach ($repos as $rep)  
                <tr>      
                    <td>{{ $rep->name }}</td>
                    <td><a href="{{ $rep->html_url}} "> {{ $rep->html_url }} </a></td>
                    <td>{{ $rep->description }}</td>
                    <td>{{ $rep->owner->login }}</td>
                    <td>{{ $rep->stargazers_count }}</td>
                    <td>
                        <a href="save/{{ $rep->id }}">
                            <button>Добавить</button>
                        </a>
                    </td>
                </tr>
            @endforeach
        @elseif (isset($repos) && count($repos) == 0)
            <h3>Репозитории не найдены. Введите имя в строку поиска.</h3>
        @else
            <?php if (User::isGuest()): ?>
                <h3>Чтобы приступить к поиску - войдите в систему!</h3><br>
            <?php else: ?>
                <h3>Введите имя репозитория в строку поиска</h3><br>
            <?php endif; ?>
        @endif
      </tbody>
    </table>
    @if ($repos)
        {{ $repos->links() }}
    @endif    
</div>
</div>
@endsection