{{ $slot }}
<form action={{route('site.contato')}} method="POST">
    @csrf
    <input type="text" value="{{old('nome')}}" placeholder="Nome" class="{{$classe}}" name="nome">
    @if($errors->has('nome'))
        {{$errors->first('nome')}}
    @endif
    <br>
    <input type="text" value="{{old('telefone')}}" placeholder="Telefone" class="{{$classe}}" name="telefone">
    {{ $errors-> has('telefone') ? $errors->first('telefone') : '' }}
    <br>
    
    <input type="text" value="{{old('email')}}" placeholder="E-mail" class="{{$classe}}" name="email">
    {{ $errors-> has('email') ? $errors->first('email') : '' }}
    <br>
    <select class="{{$classe}}" name="motivo_contato_id">
        <option value="">Qual o motivo do contato?</option>
        @foreach($motivo_contatos as $key => $motivo_contato)
            <option value="{{$motivo_contato->id}}" {{old('motivo_contato_id') == $motivo_contato->id ? 'selected' : ''}}>{{$motivo_contato->motivo_contato}}</option>
        @endforeach
    </select>
    {{ $errors-> has('motivo_contato_id') ? $errors->first('motivo_contato_id') : '' }}
    <br>
    <textarea class="{{$classe}}"  name="mensagem" placeholder="Preencha aqui a sua mensagem">{{old('mensagem')}}</textarea>
    {{ $errors-> has('mensagem') ? $errors->first('mensagem') : '' }}
    <br>
    
    <button type="submit" class="{{$classe}}">ENVIAR</button>
</form>

@if($errors->any())
    <div style="position:absolute; top:0px; left:0px; width:100%; background-color: #000; color: #fff; text-align: center;"> 
        @foreach($errors->all() as $erro)
            {{$erro}}
            <br>
        @endforeach
    </div>
@endif