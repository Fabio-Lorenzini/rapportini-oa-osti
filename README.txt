RAPPORTINI OA OSTI — APP CON BACKUP AUTOMATICO SU NAS

Contiene l'app PWA aggiornata, api.php e config.example.php.
Per installare il backend Synology seguire README_INSTALLAZIONE_NAS.txt.

Il backup NAS è tentato al primo accesso e, in seguito, al primo accesso utile dopo almeno 24 ore dall'ultimo backup riuscito. Per ogni identificativo viene mantenuta una sola copia, sostituita a ogni backup riuscito.
Gli archivi locali già esistenti sono mantenuti: l'app usa la chiave localStorage oaosti_reports_v1.
