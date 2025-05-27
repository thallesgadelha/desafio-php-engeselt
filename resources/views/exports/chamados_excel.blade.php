<table>
    <thead>
        <tr>
            <th><strong>Título</strong></th>
            <th><strong>Descrição</strong></th>
            <th><strong>Responsável</strong></th>
            <th><strong>Prioridade</strong></th>
            <th><strong>Categoria</strong></th>
            <th><strong>Criado em</strong></th>
            <th><strong>Atualizado em</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($chamados as $chamado)
            <tr>
                <td>{{ $chamado->titulo }}</td>
                <td>{{ $chamado->descricao }}</td>
                <td>{{ $chamado->user?->name ?? 'N/A' }}</td>
                <td>{{ $chamado->prioridade }}</td>
                <td>{{ $chamado->categoria }}</td>
                <td>{{ optional($chamado->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ optional($chamado->updated_at)->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
