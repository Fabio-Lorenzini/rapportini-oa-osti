RAPPORTINI OA OSTI — VERSIONE PWA CON BACKUP LOCALE

CONTENUTO
- index.html: app per rapportini, archivio, calendario e backup.
- manifest.webmanifest: impostazioni di installazione PWA.
- service-worker.js: cache dei file dell'app per l'uso offline dopo il primo caricamento.

FUNZIONI MANTENUTE
- Ore lavorate obbligatorie e indicate con asterisco.
- Bozze evidenziate in rosso.
- Invio WhatsApp al numero fisso +39 331 730 5949.
- Archivio e calendario con riepilogo ore per operaio.

BACKUP
- Il backup automatico interno viene aggiornato alla prima apertura utile quando è trascorsa una settimana; sostituisce la copia interna precedente.
- “Esporta backup” scarica un file JSON da conservare separatamente.
- “Ripristina da file” importa un backup e sostituisce l'archivio corrente.
- Il backup automatico interno è conservato nella memoria del sito/app e NON protegge dalla cancellazione completa dei dati del sito o dalla disinstallazione. Per una copia indipendente, esportare il file e conservarlo in File/Documenti o su un altro supporto.
- Per non accumulare file, il backup automatico interno mantiene una sola copia; le esportazioni manuali scaricano invece file con data nel nome.

INSTALLAZIONE SU ANDROID E IPHONE (SENZA STORE)
Questi file costituiscono una PWA statica. Per installarla come app, devono essere pubblicati su un indirizzo HTTPS. Non basta aprire index.html direttamente dal file ZIP: installazione PWA e service worker richiedono un sito HTTPS (localhost solo per test).
- Android/Chrome: aprire l'indirizzo HTTPS, menu del browser, “Installa app” o “Aggiungi a schermata Home”.
- iPhone/Safari: aprire l'indirizzo HTTPS, Condividi, “Aggiungi alla schermata Home”.

LIMITI IMPORTANTI
- Non usa un database/server remoto e non sincronizza i rapportini fra telefoni. Ogni dispositivo ha il proprio archivio.
- Non può scrivere silenziosamente un file di backup settimanale in una cartella arbitraria del telefono: iOS e Android limitano l'accesso ai file. Il backup automatico è interno; l'esportazione esterna richiede l'azione dell'utente.
- Se si cancella la memoria del sito/app, il backup interno può essere cancellato insieme ai dati principali.
- La routine settimanale scatta quando l'app viene aperta dopo almeno 7 giorni, non se resta chiusa.

NOTA TECNICA
L'app migra automaticamente i rapportini presenti nella chiave localStorage oaosti_reports_v1 se si apre nello stesso browser/origine che li contiene. Cambiare indirizzo web o dominio può far apparire un archivio vuoto: esportare prima un backup e poi importarlo nella nuova installazione.


AGGIORNAMENTO OA OSTI
- Logo completo incorporato (logo-oa-osti.png), disponibile anche offline.
- Icone PWA 192x192 e 512x512 incluse nel manifest.
- Ore lavorate obbligatorie, con asterisco nel campo.
- Le bozze nell’archivio sono evidenziate in rosso.
- Invio WhatsApp indirizzato al numero fisso +39 331 730 5949.
- Il service worker precarica logo e icone per uso offline.

PROTEZIONE ARCHIVIAZIONE
- All'avvio l'app chiede al browser l'archiviazione persistente, per ridurre il rischio che Chrome elimini automaticamente i dati per recuperare spazio.
- Questa richiesta NON può impedire la cancellazione manuale dei dati del sito tramite “Cancella dati di navigazione” o le impostazioni di Chrome. Per protezione reale contro tale operazione serve esportare regolarmente il backup in una posizione esterna o aggiungere una sincronizzazione remota.
