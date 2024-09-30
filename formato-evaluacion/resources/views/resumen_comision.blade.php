@php
$locale = app()->getLocale() ?: 'en';
$newLocale = str_replace('_', '-', $locale);
@endphp
<!DOCTYPE html>
<html lang="{{ $newLocale }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Formato de Evaluación docente</title>

    <x-head-resources />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body class="bg-gray-50 text-black/50">

    <div class="relative min-h-screen flex flex-col items-center justify-center">
        @if (Route::has('login'))
                                    @if (Auth::check())
                                        <section role="region" aria-label="Response form">
                                            <form class="printButtonClass">
                                                @csrf
                                                <nav class="nav flex-column" style="padding-top: 50px; height: 900px; background-color: #afc7ce;">
                                                    <div class="nav-header" style="display: flex; align-items: center; padding-top: 50px;">
                                                        <li class="nav-item">
                                                            <a class="nav-link disabled" href="#">
                                                                <i class="fa-solid fa-user"></i>{{ Auth::user()->email }}
                                                            </a>
                                                        </li>
                                                        <li style="list-style: none; margin-right: 20px;">
                                                            <a href="{{ route('login') }}">
                                                                <i class="fas fa-power-off" style="font-size: 24px;" name="cerrar_sesion"></i>
                                                            </a>
                                                        </li>
                                                    </div>
                                                    <li class="nav-item">
                                                        <a class="nav-link active" style="width: 200px;" href="{{ route('rules') }}">Artículo 10
                                                            REGLAMENTO
                                                            PEDPD</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link active" style="width: 200px;" href="{{ route('resumen') }}">Resumen (A ser
                                                            llenado
                                                            por la
                                                            Comisión del PEDPD)</a>
                                                    </li><br>
                                                    <li id="jsonDataLink" class="d-none">
                                                        <a class="nav-link active" style="width: 200px;" href="{{ route('general') }}">Mostrar datos de
                                                            los
                                                            Usuarios</a>
                                                    </li>
                                                    <li id="reportLink" class="nav-item d-none">
                                                        <a class="nav-link active" style="width: 200px;" href="{{ route('perfil') }}">Mostrar
                                                            Reporte</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        @if(Auth::user()->user_type === 'dictaminador')
                                                            <a class="nav-link active" style="width: 200px;"
                                                                href="{{ route('comision_dictaminadora') }}">Selección de Formatos</a>
                                                        @else
                                                            <a class="nav-link active" style="width: 200px;" href="{{ route('secretaria') }}">Selección de
                                                                Formatos</a>
                                                        @endif
                                                    </li>
                                                </nav>
                                            </form>
                                        </section>
                                    @endif

                                </div>
                                <x-general-header />
                                @php
    $userType = Auth::user()->user_type;
                                @endphp
                        <div class="container mt-4">
                            @if($userType == '')
                                <!-- Select para usuario con user_type vacío seleccionando dictaminadores -->
                                <label for="dictaminadorSelect">Seleccionar Dictaminador:</label>
                                <select id="dictaminadorSelect" class="form-select">
                                    <option value="">Seleccionar un dictaminador</option>
                                    <!-- Aquí se llenarán los dictaminadores con JavaScript -->
                                </select>
                            @endif
                        </div>
            <main class="container" id="formContainer" style="display: none;">
                <form id="form4" method="POST" enctype="multipart/form-data"
                    onsubmit="event.preventDefault(); submitForm('/store-resume', 'form4');">
                    @csrf
                    <div>
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="dictaminador_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                        <input type="hidden" name="user_type" value="{{ Auth::user()->user_type }}">
                        <center>
                            <h2 id="resumen">Resumen</h2>
                            <h4>A ser llenado por la Comisión del PEDPD</h4>
                        </center>
                        <table class="resumenTabla">
                            <thead>
                                <tr>
                                    <th id="actv">Actividad</th>
                                    <th id="pMaximo">Puntaje máximo</th>
                                    <th id="pComision">Puntaje otorgado Comisión PEDPD</th>
                                </tr>
                            </thead>
                            <tbody id="formData">
                                <!-- Aquí se llenarán los datos del dictaminador con JavaScript -->
                            </tbody>
                        </table>
                        <center>
                            @if(Auth::user()->user_type === 'dictaminador')
                                <button type="submit" class="btn custom-btn buttonSignature">Enviar</button>
                            @endif
                        </center>
                    </div>
                </form>
            </main>

        @endif
    </div>

    <div>

    </div>
    </div>
    </div>
    </div>

    <script>
        function handleClick(event) {
            var currentTarget = event.currentTarget;
            // Use the event data here. 
            console.log('Button clicked: ' + currentTarget.getAttribute('data-id'));
        } document.addEventListener('DOMContentLoaded', onload);



        function hayObservacion(indiceActividad) {
            var selectEscala = document.getElementById('selectEscala' + indiceActividad);
            var selectActividad = document.getElementById('selectActividad' + indiceActividad);
            var inputObservacion = document.getElementById('observacion' + indiceActividad);
            var mensajeObservacion = document.getElementById('mensajeObservacion' + indiceActividad);

            if (selectActividad.value != 0 && selectEscala.value != 0) {
                mensajeObservacion.textContent = 'Observación: ' + inputObservacion.value;
                mensajeObservacion.style.display = 'block';
                return true;
            } else {
                mensajeObservacion.style.display = 'none';
                return false;
            }
        }


        const nav = document.querySelector('nav');
        let lastScrollLeft = 0; // Variable to store the last horizontal scroll position

        window.addEventListener('scroll', () => {
            let currentScrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

            // Check if scrolling to the right
            if (currentScrollLeft > lastScrollLeft) {
                // Scrolling to the right, hide the navigation
                nav.style.display = 'none';
            } else {
                // Scrolling to the left or not horizontally, show the navigation
                nav.style.display = 'block';
            }

            lastScrollLeft = currentScrollLeft <= 0 ? 0 : currentScrollLeft; // For Mobile or negative scrolling
        });



        // Function to check if there is an observation for a specific activity
        function hayObservacion(actividad) {
            const obs = document.querySelector(`#obs${actividad}`).value;
            return obs.trim() !== '';
        }

        function minWithSum(value1, value2) {
            const sum = value1 + value2;
            return Math.min(sum, 200);


        }

        function min40(...values) {
            const sum40 = values.reduce((acc, val) => acc + val, 0);
            return Math.min(sum40, 40);
        }

        function min30(...values) {
            const sum30 = values.reduce((acc, val) => acc + val, 0);
            return Math.min(sum30, 30);
        }

        function subtotal(value1, value2) {
            const st = value1 * value2;
            return st;
        }

        function min60(...values) {
            const sum60 = values.reduce((acc, val) => acc + val, 0);
            return Math.min(sum60, 60);
        }

        function minWithSumThree(value1, value2, value3, value4) {
            const ms = value1 + value2 + value3 + value4;
            return Math.min(ms, 100);
        }

        function min50(...values) {
            const ms = values.reduce((acc, val) => acc + val, 0);
            return Math.min(ms, 50);
        }

        function minWithSumThreeFive(value1, value2) {
            const ms = value1 + value2;
            return Math.min(ms, 75);
        }

        function minTutorias() {
            // convert the arguments object to an array
            const values = Array.from(arguments);

            // use reduce to sum the values
            const ms = values.reduce((acc, current) => {
                return acc + current;
            }, 0);

            // return the minimum of ms and 200
            return Math.min(ms, 200);
        }

        function min700(...values) {
            const ms = values.reduce((acc, val) => acc + val, 0);
            return Math.min(ms, 700);
        }

        // Función para actualizar el objeto data con los valores de los campos del formulario
        function actualizarData() {
            data[this.id] = this.value;
        }


        document.addEventListener('DOMContentLoaded', function () {
            const userEmail = "{{ Auth::user()->email }}"; // Obtén el email del usuario desde Blade

            const allowedEmails = [
                'joma_18@alu.uabcs.mx',
                'oa.campillo@uabcs.mx',
                'rluna@uabcs.mx',
                'v.andrade@uabcs.mx'
            ];

            // Verifica si el email está en la lista de correos permitidos
            if (allowedEmails.includes(userEmail)) {
                // Muestra el enlace
                document.getElementById('jsonDataLink').classList.remove('d-none');
            }
        });

            document.addEventListener('DOMContentLoaded', async () => {
                    const userType = @json($userType);  // Inject user type from backend to JS

                    const docenteSelect = document.getElementById('docenteSelect');
                    const dictaminadorSelect = document.getElementById('dictaminadorSelect');
                const formContainer = document.getElementById('formContainer');
                const formDataContainer = document.getElementById('formData'); 

                    if (dictaminadorSelect && userType == '') {
                        try {
                            const response = await fetch('/get-dictaminadores');
                            const dictaminadores = await response.json();

                            dictaminadores.forEach(dictaminador => {
                                const option = document.createElement('option');
                                option.value = dictaminador.id;  // Use dictaminador ID as the value
                                option.dataset.email = dictaminador.email; // Store email in data attribute
                                option.textContent = dictaminador.email;
                                dictaminadorSelect.appendChild(option);
                            });

                            dictaminadorSelect.addEventListener('change', async (event) => {
                                const dictaminadorId = event.target.value;
                                const email = event.target.options[event.target.selectedIndex].dataset.email;  // Get email from selected option
                                if (email) {
                                        axios.get(`/api/dictaminador-final-data?email=${email}`)
                                        .then(response => {
                                            formDataContainer.innerHTML = ''; // Limpiar datos anteriores
                                            formContainer.style.display = 'block'; // Mostrar el formulario

                                            // Llenar los datos del dictaminador en la tabla
                                            for (const key in response.data) {
                                                const row = document.createElement('tr');
                                                const labelCell = document.createElement('td');
                                                const valueCell = document.createElement('td');
                                                const comisionCell = document.createElement('td');

                                                labelCell.textContent = key;
                                                valueCell.textContent = response.data[key];
                                                comisionCell.textContent = response.data[key]; // Ajusta esto según tus necesidades

                                                row.appendChild(labelCell);
                                                row.appendChild(valueCell);
                                                row.appendChild(comisionCell);
                                                formDataContainer.appendChild(row);
                                            }
                                        });
                                    }else
                                            formContainer.style.display = 'none'; // Ocultar el formulario si no hay selección
                                    });
                                    } catch (error) {
                            console.error('There was a problem with the fetch operation:', error);
                            }
                        };
                     });
                            
    </script>


</body>

</html>