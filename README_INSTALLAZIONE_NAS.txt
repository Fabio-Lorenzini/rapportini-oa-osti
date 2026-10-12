RAPPORTINI OA OSTI — BACKUP AUTOMATICO SU SYNOLOGY NAS

COSA FA
- Mantiene i rapportini e l'archivio locale già presenti sul telefono.
- Chiede nome e cognome al primo avvio che richiede il backup; li normalizza in maiuscolo senza spazi (es. MARIO ROSSI -> MARIOROSSI).
- Tenta il primo backup al primo accesso utile; successivamente, al primo accesso utile dopo almeno 24 ore dall'ultimo backup riuscito.
- Conserva un solo file per identificativo sul NAS: ogni backup riuscito sostituisce il precedente.
- Se un nuovo telefono ha l'archivio locale vuoto, cerca il backup NAS e chiede conferma prima di ripristinarlo.
- Esportazione manuale JSON e ripristino da file restano disponibili.

IMPORTANTE SULL'IDENTIFICATIVO
Questa versione usa solo nome+cognome, come richiesto. Non è una password: chi conosce l'identificativo può leggere o sostituire il backup tramite l'API. Due persone con lo stesso nome e cognome possono condividere lo stesso identificativo e sovrascriversi il backup. La soluzione va usata solo accettando questi limiti.

INSTALLAZIONE NAS
1. In File Station creare una cartella condivisa chiamata rapportini_backup, separata da web/rapportini. Non mettere i file JSON di backup nella cartella pubblica del sito.
2. Verificare il percorso reale della cartella. Questo pacchetto usa /volume1/rapportini_backup come esempio; modificare config.example.php se il volume ha un nome/percorso diverso.
3. Copiare api.php nella cartella pubblicata da Web Station: /web/rapportini/.
4. Copiare config.example.php in /web/rapportini/config.php e modificare data_dir con il percorso reale della cartella condivisa.
5. In File Station, concedere al servizio/utente di sistema che esegue PHP tramite Web Station i permessi di lettura e scrittura sulla cartella rapportini_backup. Il nome dell'utente di servizio può variare in DSM; non concedere accesso pubblico alla cartella.
6. L'endpoint deve essere raggiungibile via HTTPS a https://nasoa.synology.me:8443/api.php. Verificare che il portale Web Station usi il certificato valido per nasoa.synology.me.
7. Pubblicare i file dell'app aggiornati su GitHub Pages, mantenendo lo stesso indirizzo/origine per preservare localStorage e gli archivi già presenti.
8. Fare una prova con un identificativo di test e un rapportino non importante prima di usarlo con i dati reali.

NOTA SULLA CARTELLA
api.php scrive soltanto nella cartella configurata in config.php. La cartella dati non deve essere raggiungibile direttamente dal browser. Il file config.php contiene solo il percorso della cartella, non credenziali.

SE IL BACKUP NON FUNZIONA
Aprire la sezione “Dati e backup” dell'app: lo stato indica se il backup è riuscito. Errori comuni: API non caricata, HTTPS/certificato, porta 8443 non raggiungibile, percorso data_dir errato o permessi di scrittura mancanti.

NOTA DI COMPATIBILITÀ
Il pacchetto mantiene la chiave localStorage esistente oaosti_reports_v1. Non disinstallare l'app e non cancellare i dati del browser durante l'aggiornamento. Il service worker è aggiornato alla versione 3 per forzare il rinnovo della cache.
