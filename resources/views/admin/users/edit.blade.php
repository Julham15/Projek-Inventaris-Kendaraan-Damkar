<form action="{{ route('pengguna.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
<div>
    <select name="platon_id">
    <option value="">Pilih Platon</option>
    @foreach($platons as $platon)
        <option value="{{ $platon->id }}"
            @selected($user->platon_id == $platon->id)>
            {{ $platon->nama }}
        </option>
    @endforeach
</select>

</div>
<select name="regu_id">
    <option value="">Pilih Regu</option>
    @foreach($regus as $regu)
        <option value="{{ $regu->id }}"
            @selected($user->regu_id == $regu->id)>
            {{ $regu->platon->nama }} - {{ $regu->nama }}
        </option>
    @endforeach
</select>
</form>