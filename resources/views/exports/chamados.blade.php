<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 40px;
            color: #333;
            font-size: 12pt;
            line-height: 1.5;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 16pt;
            color: #1e40af;
            margin: 0;
            line-height: 1.2;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .info-section p {
            margin: 5px 0;
            font-size: 11pt;
            color: #374151;
        }

        .info-section .label {
            font-weight: bold;
            color: #1e40af;
            display: inline;
        }

        .info-section .value {
            display: inline;
        }

        .description {
            margin-bottom: 15px;
        }

        .description .label {
            font-weight: bold;
            color: #1e40af;
            font-size: 11pt;
            margin-bottom: 5px;
        }

        .description .text {
            font-size: 11pt;
            color: #374151;
            line-height: 1.4;
        }

        .created-by {
            margin-bottom: 10px;
        }

        .created-by p {
            font-size: 11pt;
            color: #374151;
            margin: 5px 0;
        }

        .created-by .label {
            font-weight: bold;
            color: #1e40af;
            display: inline;
        }

        .divider {
            border: 0;
            border-top: 1px solid #e5e7eb;
            margin: 20px 0;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9pt;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Relatório dos Chamados</h2>
    </div>

    @foreach($chamados as $chamado)
        <div class="info-section">
            <p>
                <span class="label">Título: </span>
                <span class="value">{{ $chamado->titulo }}</span>
            </p>
            <p>
                <span class="label">Categoria: </span>
                <span class="value">{{ $chamado->categoria }} | </span>
                <span class="label">Prioridade: </span>
                <span class="value" style="color: {{ $chamado->prioridade == 'Alta' ? '#dc2626' : ($chamado->prioridade == 'Média' ? '#d97706' : '#16a34a') }}; font-weight: bold;">
                    {{ $chamado->prioridade }}
                </span>
            </p>
            <p>
                <span class="label">Status: </span>
                <span class="value" style="color: #2563eb; font-weight: bold;">
                    {{ $chamado->status }}
                </span>
            </p>
        </div>

        <div class="description">
            <div class="label">Descrição:</div>
            <div class="text">{{ $chamado->descricao }}</div>
        </div>

        <div class="created-by">
            <p>
                <span class="label">Criado por: </span>
                Colaborador
            </p>
            <p>
                <span class="label">Criado em: </span>
                {{ $chamado->created_at->format('d/m/Y, H:i:s') }}
            </p>
        </div>
        <div class="divider"></div>
    @endforeach
</body>
</html>