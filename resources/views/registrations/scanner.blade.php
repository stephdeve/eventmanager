@extends('layouts.app')

@section('title', 'Scanner un billet')

@section('content')
    <div class="min-h-screen bg-gray-100 py-8 dark:bg-neutral-950">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white overflow-hidden shadow-xl sm:rounded-2xl dark:bg-neutral-900 dark:border dark:border-neutral-800">
                <div class="px-6 py-5 border-b border-gray-200 sm:px-8 dark:border-neutral-800">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-neutral-100">Scanner un billet</h1>
                            <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">Scannez les codes QR pour valider les
                                entrées</p>
                        </div>
                        <div id="scanner-status"
                            class="px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-full flex items-center dark:bg-blue-500/10 dark:text-blue-300">
                            <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                            <span>Prêt</span>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-6 sm:p-8">
                    <!-- Zone de scan -->
                    <div class="flex flex-col items-center">
                        <div id="reader"
                            class="relative w-full max-w-md aspect-square bg-gray-900 rounded-xl overflow-hidden shadow-2xl dark:bg-neutral-900">
                            <!-- Cadre de scan -->
                            <div id="scanner-view" class="absolute inset-0 flex items-center justify-center">
                                <div
                                    class="text-center p-6 bg-white bg-opacity-90 rounded-lg dark:bg-neutral-900 dark:bg-opacity-90 dark:text-neutral-200">
                                    <div
                                        class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-3">
                                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-neutral-100">Prêt à scanner</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">Appuyez sur le bouton pour
                                        démarrer le scan</p>
                                </div>
                            </div>

                            <!-- Contrôles du scanner -->
                            <div
                                class="absolute bottom-5 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent dark:from-neutral-900/80">
                                <div class="flex flex-col sm:flex-row justify-center gap-3">
                                    <button type="button" id="start-scanner"
                                        class="w-full sm:w-auto flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Démarrer le scan
                                    </button>

                                    <button type="button" id="stop-scanner"
                                        class="hidden w-full sm:w-auto items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-md transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z">
                                            </path>
                                        </svg>
                                        Arrêter le scan
                                    </button>
                                </div>
                            </div>

                            <!-- Cadre de scan visuel -->
                            <div
                                class="absolute inset-0 border-8 border-blue-400 border-opacity-50 rounded-lg m-2 pointer-events-none">
                                <div
                                    class="absolute -top-1 -left-1 w-12 h-12 border-t-4 border-l-4 border-blue-500 rounded-tl-lg">
                                </div>
                                <div
                                    class="absolute -top-1 -right-1 w-12 h-12 border-t-4 border-r-4 border-blue-500 rounded-tr-lg">
                                </div>
                                <div
                                    class="absolute -bottom-1 -left-1 w-12 h-12 border-b-4 border-l-4 border-blue-500 rounded-bl-lg">
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-12 h-12 border-b-4 border-r-4 border-blue-500 rounded-br-lg">
                                </div>
                            </div>
                        </div>

                        <!-- Aide pour le scanner -->
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600 flex items-center justify-center dark:text-neutral-400">
                                <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Placez le code QR dans le cadre pour le scanner
                            </p>
                        </div>
                    </div>

                    <!-- Résultats du scan -->
                    <div id="scanner-result"
                        class="hidden p-4 mb-6 bg-gray-50 rounded-lg border border-gray-200 dark:bg-neutral-900/60 dark:border-neutral-800">
                        <h3 class="text-lg font-medium text-gray-800 mb-3 dark:text-neutral-100">Résultat du scan</h3>
                        <div id="result-content" class="space-y-3"></div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <!-- Inclure la bibliothèque de scan QR code -->
            <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const startButton = document.getElementById('start-scanner');
                    const scannerResult = document.getElementById('scanner-result');
                    const resultContent = document.getElementById('result-content');
                    let html5QrCode;
                    let isScanning = false;

                    startButton.addEventListener('click', function() {
                        // Initialiser le scanner avec une zone de scan carrée
                        html5QrCode = new Html5Qrcode("reader");
                        // Définir la taille du cadre de scan à 80% de la plus petite dimension
                        const qrboxSize = Math.min(window.innerWidth * 0.8, 500);

                        // Démarrer le scanner
                        html5QrCode.start({
                                facingMode: "environment"
                            }, // Utiliser la caméra arrière
                            {
                                fps: 10,
                                qrbox: qrboxSize
                            },
                            (qrCodeMessage) => {
                                // Succès du scan
                                html5QrCode.stop();
                                isScanning = false;
                                scannerResult.classList.remove('hidden');
                                const code = extractCode(qrCodeMessage);

                                // Afficher les informations du scan
                                resultContent.innerHTML = `
                        <div class="p-3 bg-green-100 border border-green-200 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">Billet scanné avec succès !</p>
                                    <div class="mt-2 text-sm text-green-700">
                                        <p>Code du billet: <span class="font-mono">${code}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button onclick="validateTicket('${code}')" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                Valider l'entrée
                            </button>
                        </div>
                    `;
                            },
                            (errorMessage) => {
                                // Gestion des erreurs (ignorer les erreurs de scan continu)
                                if (errorMessage === "QR code parse error, error = No QR code found.") {
                                    return;
                                }
                                console.error(errorMessage);
                            }
                        ).catch(err => {
                            console.error(err);
                        });

                        // Changer le bouton pour arrêter le scan
                        document.getElementById('start-scanner').classList.add('hidden');
                        const stopBtn = document.getElementById('stop-scanner');
                        stopBtn.classList.remove('hidden');
                        stopBtn.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                </svg>
                Arrêter le scan
            `;
                        stopBtn.onclick = stopScanner;
                        isScanning = true;
                    });

                    async function stopScanner() {
                        if (html5QrCode && html5QrCode.isScanning) {
                            try {
                                await html5QrCode.stop();
                                isScanning = false;
                                console.log("Scanner arrêté avec succès");

                                // Vider la vidéo
                                const videoElement = document.querySelector('video');
                                if (videoElement) {
                                    videoElement.srcObject.getTracks().forEach(track => track.stop());
                                    videoElement.remove();
                                }

                                // Réinitialiser l'interface
                                const readerElement = document.getElementById('reader');
                                readerElement.innerHTML = `
                        <div class="text-center p-4">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">Prêt à scanner un billet</p>
                            <p class="text-xs text-gray-500">Placez le code QR dans le cadre</p>
                        </div>
                    `;

                                // Réinitialiser les boutons
                                document.getElementById('stop-scanner').classList.add('hidden');
                                const startBtn = document.getElementById('start-scanner');
                                startBtn.classList.remove('hidden');
                                startBtn.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Démarrer le scan
                    `;
                                startBtn.onclick = startNewScan;

                            } catch (err) {
                                console.error("Erreur lors de l'arrêt du scanner", err);
                                // Forcer le rechargement en cas d'erreur
                                window.location.reload();
                            }
                        } else {
                            // Si le scanner n'est pas en cours, recharger la page
                            window.location.reload();
                        }
                    }

                    // Fonction pour démarrer un nouveau scan
                    function startNewScan() {
                        window.location.reload();
                    }

                    /**
                     * Valider un ticket via son code QR
                     */
                    function extractCode(input) {
                        try {
                            const u = new URL(input);
                            const m = u.pathname.match(/\/tickets\/([^\/]+)/i);
                            if (m && m[1]) return m[1];
                        } catch (e) {
                            // not a full URL, try to match a relative path
                            const m2 = String(input).match(/\/tickets\/([^\/]+)/i);
                            if (m2 && m2[1]) return m2[1];
                        }
                        return String(input);
                    }

                    window.validateTicket = async function(code) {
                        // Afficher un indicateur de chargement
                        const validateButton = resultContent.querySelector('button[onclick^="validateTicket"]');
                        if (validateButton) {
                            const originalText = validateButton.innerHTML;
                            validateButton.disabled = true;
                            validateButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Validation en cours...
                `;

                            // Désactiver temporairement le bouton
                            validateButton.onclick = null;
                        }
                        const url = `/tickets/${encodeURIComponent(code)}/validate`;
                        const controller = new AbortController();
                        const csrfEl = document.querySelector('meta[name="csrf-token"]');
                        const csrf = csrfEl ? csrfEl.getAttribute('content') : '';
                        const timeoutId = setTimeout(() => controller.abort(), 10000);

                        try {
                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrf,
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    _token: csrf,
                                    _method: 'POST'
                                }),
                                signal: controller.signal,
                            });

                            let data;
                            const ct = response.headers.get('content-type') || '';
                            if (ct.includes('application/json')) {
                                data = await response.json();
                            } else {
                                const text = await response.text();
                                if (!response.ok) {
                                    throw new Error('Erreur serveur: ' + response.status);
                                }
                                data = {};
                            }

                            if (!response.ok) {
                                throw new Error(data?.message || 'Une erreur est survenue lors de la validation');
                            }

                            const notice = data?.registration?.notice;
                            const paymentStatus = (data?.registration?.payment_status || '').toUpperCase();

                            resultContent.innerHTML = `
                    <div class="rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z\" clip-rule=\"evenodd\" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">Billet validé avec succès !</h3>
                                <div class="mt-2 text-sm text-green-700 space-y-1">
                                    <p>Événement: <span class="font-medium">${data.registration?.event?.title || 'Non spécifié'}</span></p>
                                    <p>Participant: <span class="font-medium">${data.registration?.user?.name || 'Non spécifié'}</span></p>
                                    ${paymentStatus ? `<p class="text-xs text-gray-700">Statut paiement: <span class="font-semibold">${paymentStatus}</span></p>` : ''}
                                    <p class="mt-2 text-xs text-green-600">Validé le ${new Date().toLocaleDateString()} à ${new Date().toLocaleTimeString()}</p>
                                </div>
                                ${notice ? `
                                            <div class="mt-3 rounded-md border border-amber-200 bg-amber-50 p-3 text-amber-900 text-xs">
                                                ${notice}
                                            </div>` : ''}
                                <div class="mt-4">
                                    <button type="button" onclick="window.location.reload()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                        Scanner un autre billet
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>`;
                        } catch (error) {
                            console.error('Erreur lors de la validation:', error);
                            const errorMessage = (error.name === 'AbortError') ?
                                'Délai dépassé. Vérifiez votre connexion.' : (error.message ||
                                    'Une erreur est survenue lors de la validation du billet');
                            resultContent.innerHTML = `
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Erreur lors de la validation</h3>
                                <div class="mt-2 text-sm text-red-700"><p>${errorMessage}</p></div>
                                <div class="mt-4 flex space-x-3">
                                    <button type="button" onclick="window.location.reload()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</button>
                                    <button type="button" onclick="validateTicket('${code}')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Réessayer</button>
                                </div>
                            </div>
                        </div>
                    </div>`;
                        } finally {
                            clearTimeout(timeoutId);
                        }
                    };

                    // Gérer la visibilité de l'onglet
                    document.addEventListener('visibilitychange', function() {
                        if (document.hidden && isScanning) {
                            stopScanner();
                        }
                    });

                    // Nettoyer à la fermeture de la page
                    window.addEventListener('pagehide', () => {
                        if (isScanning && html5QrCode) {
                            html5QrCode.stop().catch(console.error);
                        }
                    });
                });
            </script>
        @endpush
    @endsection
