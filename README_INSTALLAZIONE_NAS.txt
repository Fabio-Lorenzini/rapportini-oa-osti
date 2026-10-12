RAPPORTINI OA OSTI — BACKUP AUTOMATICO SU SYNOLOGY NAS

PACCHETTO PRECONFIGURATO
- Cartella dati configurata: /volume1/Backups/rapportini_backup
- API: /web/rapportini/api.php
- Configurazione: /web/rapportini/config.php
- Origine autorizzata per le richieste dal browser: https://fabio-lorenzini.github.io

COSA FA
- Mantiene i rapportini e l'archivio locale già presenti sul telefono.
- Chiede nome e cognome al primo avvio che richiede il backup; li normalizza in maiuscolo senza spazi (es. MARIO ROSSI -> MARIOROSSI).
- Tenta il primo backup al primo accesso utile; successivamente, al primo accesso utile dopo almeno 24 ore dall'ultimo backup riuscito.
- Conserva un solo file per identificativo sul NAS: ogni backup riuscito sostituisce il precedente.
- Se un nuovo telefono ha l'archivio locale vuoto, cerca il backup NAS e chiede conferma prima di ripristinarlo.
- Esportazione manuale JSON e ripristino da file restano disponibili.

INSTALLAZIONE NAS
1. La cartella condivisa Backups/rapportini_backup deve esistere fuori dalla cartella pubblica web.
2. Il percorso configurato è /volume1/Backups/rapportini_backup. È basato sulla posizione indicata come Volume 1 e sul nome della cartella condivisa Backups; se il servizio restituisce un errore di cartella non disponibile, verifichiamo il percorso reale.
3. Copiare api.php e config.php nella cartella pubblicata da Web Station: /web/rapportini/.
4. Verificare che il gruppo/utente di sistema che esegue PHP tramite Web Station abbia lettura e scrittura SOLO nella cartella rapportini_backup. Non concedere accesso pubblico e non modificare i permessi di tutta la cartella Backups se non necessario.
5. Verificare che il portale Web Station risponda via HTTPS a https://nasoa.synology.me:8443/api.php e abbia assegnato un certificato valido per nasoa.synology.me.
6. Dopo il test dell'API, pubblicare i file dell'app aggiornati su GitHub Pages mantenendo l'origine https://fabio-lorenzini.github.io/rapportini-oa-osti/; questo conserva l'accesso allo stesso localStorage se l'URL non cambia.
7. Fare una prova con un identificativo di test e dati non importanti prima di usarlo realmente.

IMPORTANTE
- La cartella dei backup è esterna alla web root. Non salvare file JSON di backup dentro /web/rapportini.
- L'identificativo è solo nome+cognome e non è una password: chi conosce l'identificativo può leggere o sostituire quel backup. Due persone con lo stesso nome e cognome possono condividere lo stesso file.
- L'API accetta richieste browser soltanto dall'origine GitHub Pages configurata; CORS non è una protezione di autenticazione e non impedisce chiamate dirette.
- Il backup NAS non cancella l'archivio locale. Il file NAS viene sostituito soltanto quando un nuovo backup è riuscito.
- Non disinstallare l'app e non cancellare i dati del browser durante l'aggiornamento.

SE IL BACKUP NON FUNZIONA
Nella sezione “Dati e backup” controllare lo stato NAS. Errori comuni: API non caricata, certificato/HTTPS, porta 8443 non raggiungibile, percorso data_dir errato o permessi di scrittura mancanti.
