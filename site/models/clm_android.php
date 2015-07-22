<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * Clm_android Model
 */
class Clm_androidModelClm_android extends JModelItem
{
        /**
         * @var string msg
         */
        protected $msg;
	protected $id;
	protected $task;
	protected $format;
	protected $juser;
	protected $db;

	/**
	 * aktuelle SaisonId auslesen
	 */
	private function getAktuelleSaisonId() {
		$query = $this->db->getQuery(true);
		$query->select('id');
		$query->from('#__clm_saison');
		$query->where('archiv=0 AND published=1');
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$saisons = $this->db->loadObjectList();
		foreach ($saisons as $key => $saison) {
			return $saison->id;
		}
		return null;
	}

	/**
	 * ClmUserId der Saison auslesen
	 */
	private function getClmUserId($sid, $uid) {
		$query = $this->db->getQuery(true);
		$query->select('id');
		$query->from('#__clm_user');
		$query->where('jid=' . $uid . ' AND sid=' . $sid);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$users = $this->db->loadObjectList();
		foreach ($users as $key => $user) {
			return $user->id;
		}
		return null;
	}

	/**
	 * userType auslesen
	 */
	private function getClmUserType($uid) {
		$query = $this->db->getQuery(true);
		$query->select('usertype');
		$query->from('#__clm_user');
		$query->where('id=' . $uid);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$users = $this->db->loadObjectList();
		foreach ($users as $key => $user) {
			return $user->usertype;
		}
		return null;
	}

	/**
	 * userZps auslesen
	 */
	private function getClmUserZps($uid) {
		$query = $this->db->getQuery(true);
		$query->select('zps');
		$query->from('#__clm_user');
		$query->where('id=' . $uid);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$users = $this->db->loadObjectList();
		foreach ($users as $key => $user) {
			return $user->zps;
		}
		return null;
	}

	/**
	 * userMglnr auslesen
	 */
	private function getClmUserMglnr($uid) {
		$query = $this->db->getQuery(true);
		$query->select('mglnr');
		$query->from('#__clm_user');
		$query->where('id=' . $uid);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$users = $this->db->loadObjectList();
		foreach ($users as $key => $user) {
			return $user->mglnr;
		}
		return null;
	}

	/**
         * get DWZ club list in xml structure
         */
        public function getDwzVereine($sid, $zps, $spaces) {
		$query2 = $this->db->getQuery(true);
		$query2->select('*');
		$query2->from('#__clm_dwz_vereine');
		$query2->where('sid=' . $sid . ' AND zps like \'' . $zps . '%\'');
		$query2->order('zps');
		$this->db->setQuery((string)$query2);
		$this->queries = $this->queries . "<pre>" . (string)$query2 . "\n</pre>";
		$clm_dwz_vereineliste = $this->db->loadObjectList();
		$result = $spaces . "<clm_dwz_vereineliste>\n";
		foreach ($clm_dwz_vereineliste as $key => $clm_dwz_vereine) {
			$result .= $spaces . " <clm_dwz_vereine>\n";
			$result .= $spaces . "  <id>" . $clm_dwz_vereine->id . "</id>\n";
			$result .= $spaces . "  <sid>" . $clm_dwz_vereine->sid . "</sid>\n";
			$result .= $spaces . "  <ZPS>" . $clm_dwz_vereine->ZPS . "</ZPS>\n";
			$result .= $spaces . "  <LV>" . $clm_dwz_vereine->LV . "</LV>\n";
			$result .= $spaces . "  <Verband>" . $clm_dwz_vereine->Verband . "</Verband>\n";
			$result .= $spaces . "  <Vereinname>" . $clm_dwz_vereine->Vereinname . "</Vereinname>\n";
			$result .= $spaces . " </clm_dwz_vereine>\n";
		}
		$result .= $spaces . "</clm_dwz_vereineliste>\n";
		return $result;
	}

	/**
         * get round dates and names list in xml structure
         */
        public function getRundenTermine($id, $spaces) {
		$query2 = $this->db->getQuery(true);
		$query2->select('*');
		$query2->from('#__clm_turniere_rnd_termine');
		$query2->where('turnier=' . $id);
		$query2->order('nr');
		$this->db->setQuery((string)$query2);
		$this->queries = $this->queries . "<pre>" . (string)$query2 . "\n</pre>";
		$clm_turniere_rnd_termineliste = $this->db->loadObjectList();
		$result = $spaces . "<clm_turniere_rnd_termineliste>\n";
		foreach ($clm_turniere_rnd_termineliste as $key => $clm_turniere_rnd_termine) {
			$result .= $spaces . " <clm_turniere_rnd_termine>\n";
			$result .= $spaces . "  <id>" . $clm_turniere_rnd_termine->id . "</id>\n";
			$result .= $spaces . "  <sid>" . $clm_turniere_rnd_termine->sid . "</sid>\n";
			$result .= $spaces . "  <name>" . $clm_turniere_rnd_termine->name . "</name>\n";
			$result .= $spaces . "  <turnier>" . $clm_turniere_rnd_termine->turnier . "</turnier>\n";
			$result .= $spaces . "  <dg>" . $clm_turniere_rnd_termine->dg . "</dg>\n";
			$result .= $spaces . "  <nr>" . $clm_turniere_rnd_termine->nr . "</nr>\n";
			$result .= $spaces . "  <datum>" . $clm_turniere_rnd_termine->datum . "</datum>\n";
			$result .= $spaces . "  <startzeit>" . $clm_turniere_rnd_termine->startzeit . "</startzeit>\n";
			$result .= $spaces . "  <abgeschlossen>" . $clm_turniere_rnd_termine->abgeschlossen . "</abgeschlossen>\n";
			$result .= $spaces . "  <tl_ok>" . $clm_turniere_rnd_termine->tl_ok . "</tl_ok>\n";
			$result .= $spaces . "  <published>" . $clm_turniere_rnd_termine->published . "</published>\n";
			$result .= $spaces . "  <bemerkungen>" . $clm_turniere_rnd_termine->bemerkungen . "</bemerkungen>\n";
			$result .= $spaces . "  <bem_int>" . $clm_turniere_rnd_termine->bem_int . "</bem_int>\n";
			$result .= $spaces . "  <gemeldet>" . $clm_turniere_rnd_termine->gemeldet . "</gemeldet>\n";
			$result .= $spaces . "  <editor>" . $clm_turniere_rnd_termine->editor . "</editor>\n";
			$result .= $spaces . "  <zeit>" . $clm_turniere_rnd_termine->zeit . "</zeit>\n";
			$result .= $spaces . "  <edit_zeit>" . $clm_turniere_rnd_termine->edit_zeit . "</edit_zeit>\n";
			$result .= $spaces . "  <checked_out>" . $clm_turniere_rnd_termine->checked_out . "</checked_out>\n";
			$result .= $spaces . "  <checked_out_time>" . $clm_turniere_rnd_termine->checked_out_time . "</checked_out_time>\n";
			$result .= $spaces . "  <ordering>" . $clm_turniere_rnd_termine->ordering . "</ordering>\n";
			$result .= $spaces . " </clm_turniere_rnd_termine>\n";
		}
		$result .= $spaces . "</clm_turniere_rnd_termineliste>\n";
		return $result;
	}

	/**
         * get DWZ player in xml structure
         */
	public function Spieler2Xml($spieler, $spaces) {
		$text = "";
		$text .= $spaces . "<clm_dwz_spieler>\n";
		$text .= $spaces . " <id>" . $spieler->id . "</id>\n";
		$text .= $spaces . " <sid>" . $spieler->sid . "</sid>\n";
		$text .= $spaces . " <PKZ>" . $spieler->PKZ . "</PKZ>\n";
		$text .= $spaces . " <ZPS>" . $spieler->ZPS . "</ZPS>\n";
		$text .= $spaces . " <Mgl_Nr>" . $spieler->Mgl_Nr . "</Mgl_Nr>\n";
		$text .= $spaces . " <Status>" . $spieler->Status . "</Status>\n";
		$text .= $spaces . " <Spielername>" . $spieler->Spielername . "</Spielername>\n";
		$text .= $spaces . " <Spielername_G>" . $spieler->Spielername_G . "</Spielername_G>\n";
		$text .= $spaces . " <Geschlecht>" . $spieler->Geschlecht . "</Geschlecht>\n";
		$text .= $spaces . " <Spielberechtigung>" . $spieler->Spielberechtigung . "</Spielberechtigung>\n";
		$text .= $spaces . " <Geburtsjahr>" . $spieler->Geburtsjahr . "</Geburtsjahr>\n";
		$text .= $spaces . " <Letzte_Auswertung>" . $spieler->Letzte_Auswertung . "</Letzte_Auswertung>\n";
		$text .= $spaces . " <DWZ>" . $spieler->DWZ . "</DWZ>\n";
		$text .= $spaces . " <DWZ_Index>" . $spieler->DWZ_Index . "</DWZ_Index>\n";
		$text .= $spaces . " <FIDE_Elo>" . $spieler->FIDE_Elo . "</FIDE_Elo>\n";
		$text .= $spaces . " <FIDE_Titel>" . $spieler->FIDE_Titel . "</FIDE_Titel>\n";
		$text .= $spaces . " <FIDE_ID>" . $spieler->FIDE_ID . "</FIDE_ID>\n";
		$text .= $spaces . " <FIDE_Land>" . $spieler->FIDE_Land . "</FIDE_Land>\n";
		$text .= $spaces . " <DWZ_neu>" . $spieler->DWZ_neu . "</DWZ_neu>\n";
		$text .= $spaces . " <I0>" . $spieler->I0 . "</I0>\n";
		$text .= $spaces . " <Punkte>" . $spieler->Punkte . "</Punkte>\n";
		$text .= $spaces . " <Partien>" . $spieler->Partien . "</Partien>\n";
		$text .= $spaces . " <We>" . $spieler->We . "</We>\n";
		$text .= $spaces . " <Leistung>" . $spieler->Leistung . "</Leistung>\n";
		$text .= $spaces . " <EFaktor>" . $spieler->EFaktor . "</EFaktor>\n";
		$text .= $spaces . " <Niveau>" . $spieler->Niveau . "</Niveau>\n";
		$text .= $spaces . "</clm_dwz_spieler>\n";
		return $text;
	}

	/**
         * get DWZ player list in xml structure
         */
        public function getDwzSpieler($sid, $zps, $spaces) {
		$query2 = $this->db->getQuery(true);
		$query2->select('*');
		$query2->from('#__clm_dwz_spieler');
		$query2->where('sid=' . $sid . ' AND zps like \'' . $zps . '%\'');
		$query2->order('zps,Mgl_Nr');
		$this->db->setQuery((string)$query2);
		$this->queries = $this->queries . "<pre>" . (string)$query2 . "\n</pre>";
		$text = $spaces . "<clm_dwz_spieler_liste>\n";
		$gspaces = $spaces;
		$spaces .= " ";
		$spielerliste = $this->db->loadObjectList();
		foreach ($spielerliste as $key => $spieler) {
			$text .= $this->Spieler2Xml($spieler, $spaces);
		}
		$text .= $gspaces . "</clm_dwz_spieler_liste>\n";
		return $text;
	}

	/**
         * get DWZ player list in xml structure for single player
         */
        public function getDwzEinzelSpieler($sid, $zps, $mglnr, $spaces) {
		$query2 = $this->db->getQuery(true);
		$query2->select('*');
		$query2->from('#__clm_dwz_spieler');
		$query2->where('sid=' . $sid . ' AND zps=\'' . $zps . '\' AND Mgl_Nr in (\'' . $mglnr . '\', \'0' . $mglnr . '\', \'00' . $mglnr . '\', \'000' . $mglnr . '\')');
		$query2->order('zps,Mgl_Nr');
		$this->db->setQuery((string)$query2);
		$this->queries = $this->queries . "<pre>" . (string)$query2 . "\n</pre>";
		# file_put_contents('php://stderr', "Query was: " . (string)$query2);
		$text = $spaces . "<clm_dwz_spieler_liste>\n";
		$gspaces = $spaces;
		$spaces .= " ";
		$spielerliste = $this->db->loadObjectList();
		foreach ($spielerliste as $key => $spieler) {
			$text .= $this->Spieler2Xml($spieler, $spaces);
		}
		$text .= $gspaces . "</clm_dwz_spieler_liste>\n";
		return $text;
	}

	/**
         * get Tourney game list in xml structure
         */
        public function getTourneyGames($tourneyId, $spaces) {
		$query2 = $this->db->getQuery(true);
		$query2->select('*');
		$query2->from('#__clm_turniere_rnd_spl');
		$query2->where('turnier=' . $tourneyId);
		$query2->order('runde,brett');
		$this->db->setQuery((string)$query2);
		$this->queries = $this->queries . "<pre>" . (string)$query2 . "\n</pre>";
		$clm_turniere_rnd_splliste = $this->db->loadObjectList();
		$result = $spaces . "<clm_turniere_rnd_splliste>\n";
		foreach ($clm_turniere_rnd_splliste as $key => $clm_turniere_rnd_spl) {
			$result .= $spaces . " <clm_turniere_rnd_spl>\n";
			$result .= $spaces . "  <id>" . $clm_turniere_rnd_spl->id . "</id>\n";
			$result .= $spaces . "  <sid>" . $clm_turniere_rnd_spl->sid . "</sid>\n";
			$result .= $spaces . "  <turnier>" . $clm_turniere_rnd_spl->turnier . "</turnier>\n";
			$result .= $spaces . "  <runde>" . $clm_turniere_rnd_spl->runde . "</runde>\n";
			$result .= $spaces . "  <paar>" . $clm_turniere_rnd_spl->paar . "</paar>\n";
			$result .= $spaces . "  <brett>" . $clm_turniere_rnd_spl->brett . "</brett>\n";
			$result .= $spaces . "  <dg>" . $clm_turniere_rnd_spl->dg . "</dg>\n";
			$result .= $spaces . "  <tln_nr>" . $clm_turniere_rnd_spl->tln_nr . "</tln_nr>\n";
			$result .= $spaces . "  <heim>" . $clm_turniere_rnd_spl->heim . "</heim>\n";
			$result .= $spaces . "  <spieler>" . $clm_turniere_rnd_spl->spieler . "</spieler>\n";
			$result .= $spaces . "  <gegner>" . $clm_turniere_rnd_spl->gegner . "</gegner>\n";
			$result .= $spaces . "  <ergebnis>" . $clm_turniere_rnd_spl->ergebnis . "</ergebnis>\n";
			$result .= $spaces . "  <tiebrS>" . $clm_turniere_rnd_spl->tiebrS . "</tiebrS>\n";
			$result .= $spaces . "  <tiebrG>" . $clm_turniere_rnd_spl->tiebrG . "</tiebrG>\n";
			$result .= $spaces . "  <kampflos>" . $clm_turniere_rnd_spl->kampflos . "</kampflos>\n";
			$result .= $spaces . "  <gemeldet>" . $clm_turniere_rnd_spl->gemeldet . "</gemeldet>\n";
			$result .= $spaces . "  <pgn>" . $clm_turniere_rnd_spl->pgn . "</pgn>\n";
			$result .= $spaces . "  <ordering>" . $clm_turniere_rnd_spl->ordering . "</ordering>\n";
			$result .= $spaces . " </clm_turniere_rnd_spl>\n";
		}
		$result .= $spaces . "</clm_turniere_rnd_splliste>\n";
		return $result;
	}

	/**
         * get Tourney player list in xml structure
         */
        public function getAPI($rights, $zps, $mglnr, $spaces) {
		$query2 = $this->db->getQuery(true);
		$query2->select('manifest_cache');
		$query2->from('#__extensions');
		$query2->where('element=\'com_clm\'');
		$this->db->setQuery((string)$query2);
		$this->queries = $this->queries . "<pre>" . (string)$query2 . "\n</pre>";
		$apis = $this->db->loadObjectList();
		$text = $spaces . "<API_liste>\n";
		$gspaces = $spaces;
		$spaces .= " ";
		foreach ($apis as $key => $api) {
			$data = json_decode($api->manifest_cache, false);
			$clmVersion = $data->version;
		}
		$query2 = $this->db->getQuery(true);
		$query2->select('manifest_cache');
		$query2->from('#__extensions');
		$query2->where('element=\'com_clm_android\'');
		$this->db->setQuery((string)$query2);
		$this->queries = $this->queries . "<pre>" . (string)$query2 . "\n</pre>";
		$apis = $this->db->loadObjectList();
		$text = $spaces . "<API_liste>\n";
		$gspaces = $spaces;
		$spaces .= " ";
		foreach ($apis as $key => $api) {
			$data = json_decode($api->manifest_cache, false);
			$andVersion = $data->version;
		}
		try {
			$query2 = $this->db->getQuery(true);
			$query2->select('id');
			$query2->from('#__com_teams_spieler');
			$query2->where("zps='". $zps . "' AND mglnr=" . $mglnr);
			$this->db->setQuery((string)$query2);
			$this->queries = $this->queries . "<pre>" . (string)$query2 . "\n</pre>";
			$spielers = $this->db->loadObjectList();
		}
		catch (Exception $e){
			// Optionale Komponente nicht installiert
			$spielers = null;
		}

		$team_list = "";
		if ($spielers != null) {
			foreach ($spielers as $key => $spieler) {
				$id = $spieler->id;
				$team_list .= $spaces . " <teams_spieler>" . $id . "</teams_spieler>\n";
			}
		}
		$text .= $spaces . "<API>\n";
		$text .= $spaces . " <com_clm_Version>" . $clmVersion . "</com_clm_Version>\n";
		$text .= $spaces . " <com_clm_android_Version>" . $andVersion . "</com_clm_android_Version>\n";
		$text .= $spaces . " <user_zps>" . $zps . "</user_zps>\n";
		$text .= $spaces . " <user_mglnr>" . $mglnr . "</user_mglnr>\n";
		$text .= $spaces . " <user_rights>" . $rights . "</user_rights>\n";
		$text .= $team_list;
		$text .= $spaces . "</API>\n";
		$text .= $gspaces . "</API_liste>\n";
		return $text;
	}

	/**
         * get Tourney player list in xml structure
         */
        public function getTourneyPlayers($tourneyId, $spaces) {
		$query = $this->db->getQuery(true);
		$query->select('*');
		$query->from('#__clm_turniere_tlnr');
		$query->where('turnier=' . $tourneyId);
		$query->order('snr');
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$clm_turniere_tlnrliste = $this->db->loadObjectList();
		$result = $spaces . "<clm_turniere_tlnrliste>\n";
		foreach ($clm_turniere_tlnrliste as $key => $clm_turniere_tlnr) {
			$result .= $spaces . " <clm_turniere_tlnr>\n";
			$result .= $spaces . "  <id>" . $clm_turniere_tlnr->id . "</id>\n";
			$result .= $spaces . "  <sid>" . $clm_turniere_tlnr->sid . "</sid>\n";
			$result .= $spaces . "  <turnier>" . $clm_turniere_tlnr->turnier . "</turnier>\n";
			$result .= $spaces . "  <snr>" . $clm_turniere_tlnr->snr . "</snr>\n";
			$result .= $spaces . "  <name>" . $clm_turniere_tlnr->name . "</name>\n";
			$result .= $spaces . "  <birthYear>" . $clm_turniere_tlnr->birthYear . "</birthYear>\n";
			$result .= $spaces . "  <geschlecht>" . $clm_turniere_tlnr->geschlecht . "</geschlecht>\n";
			$result .= $spaces . "  <verein>" . $clm_turniere_tlnr->verein . "</verein>\n";
			$result .= $spaces . "  <twz>" . $clm_turniere_tlnr->twz . "</twz>\n";
			$result .= $spaces . "  <FIDEelo>" . $clm_turniere_tlnr->FIDEelo . "</FIDEelo>\n";
			$result .= $spaces . "  <FIDEid>" . $clm_turniere_tlnr->FIDEid . "</FIDEid>\n";
			$result .= $spaces . "  <FIDEcco>" . $clm_turniere_tlnr->FIDEcco . "</FIDEcco>\n";
			$result .= $spaces . "  <titel>" . $clm_turniere_tlnr->titel . "</titel>\n";
			$result .= $spaces . "  <mgl_nr>" . $clm_turniere_tlnr->mgl_nr . "</mgl_nr>\n";
			$result .= $spaces . "  <zps>" . $clm_turniere_tlnr->zps . "</zps>\n";
			$result .= $spaces . "  <status>" . $clm_turniere_tlnr->status . "</status>\n";
			$result .= $spaces . "  <rankingPos>" . $clm_turniere_tlnr->rankingPos . "</rankingPos>\n";
			$result .= $spaces . "  <tlnrStatus>" . $clm_turniere_tlnr->tlnrStatus . "</tlnrStatus>\n";
			$result .= $spaces . "  <anz_spiele>" . $clm_turniere_tlnr->anz_spiele . "</anz_spiele>\n";
			$result .= $spaces . "  <sum_punkte>" . $clm_turniere_tlnr->sum_punkte . "</sum_punkte>\n";
			$result .= $spaces . "  <sum_bhlz>" . $clm_turniere_tlnr->sum_bhlz . "</sum_bhlz>\n";
			$result .= $spaces . "  <sum_busum>" . $clm_turniere_tlnr->sum_busum . "</sum_busum>\n";
			$result .= $spaces . "  <sum_sobe>" . $clm_turniere_tlnr->sum_sobe . "</sum_sobe>\n";
			$result .= $spaces . "  <sum_wins>" . $clm_turniere_tlnr->sum_wins . "</sum_wins>\n";
			$result .= $spaces . "  <sumTiebr1>" . $clm_turniere_tlnr->sumTiebr1 . "</sumTiebr1>\n";
			$result .= $spaces . "  <sumTiebr2>" . $clm_turniere_tlnr->sumTiebr2 . "</sumTiebr2>\n";
			$result .= $spaces . "  <sumTiebr3>" . $clm_turniere_tlnr->sumTiebr3 . "</sumTiebr3>\n";
			$result .= $spaces . "  <koStatus>" . $clm_turniere_tlnr->koStatus . "</koStatus>\n";
			$result .= $spaces . "  <koRound>" . $clm_turniere_tlnr->koRound . "</koRound>\n";
			$result .= $spaces . "  <DWZ>" . $clm_turniere_tlnr->DWZ . "</DWZ>\n";
			$result .= $spaces . "  <I0>" . $clm_turniere_tlnr->I0 . "</I0>\n";
			$result .= $spaces . "  <Punkte>" . $clm_turniere_tlnr->Punkte . "</Punkte>\n";
			$result .= $spaces . "  <Partien>" . $clm_turniere_tlnr->Partien . "</Partien>\n";
			$result .= $spaces . "  <We>" . $clm_turniere_tlnr->We . "</We>\n";
			$result .= $spaces . "  <Leistung>" . $clm_turniere_tlnr->Leistung . "</Leistung>\n";
			$result .= $spaces . "  <EFaktor>" . $clm_turniere_tlnr->EFaktor . "</EFaktor>\n";
			$result .= $spaces . "  <Niveau>" . $clm_turniere_tlnr->Niveau . "</Niveau>\n";
			$result .= $spaces . "  <published>" . $clm_turniere_tlnr->published . "</published>\n";
			$result .= $spaces . "  <checked_out>" . $clm_turniere_tlnr->checked_out . "</checked_out>\n";
			$result .= $spaces . "  <checked_out_time>" . $clm_turniere_tlnr->checked_out_time . "</checked_out_time>\n";
			$result .= $spaces . "  <ordering>" . $clm_turniere_tlnr->ordering . "</ordering>\n";
			$result .= $spaces . " </clm_turniere_tlnr>\n";
		}
		$result .= $spaces . "</clm_turniere_tlnrliste>\n";
		return $result;
	}

	/**
         * get Season list in xml structure
         */
        public function getSaisonList($spaces) {
		$query = $this->db->getQuery(true);
		$query->select('*');
		$query->from('#__clm_saison');
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$clm_saisonliste = $this->db->loadObjectList();
                $result = $spaces . "<clm_saisonliste>\n";
                foreach ($clm_saisonliste as $key => $clm_saison) {
                        $result .= $spaces . " <clm_saison>\n";
                        $result .= $spaces . "  <id>" . $clm_saison->id . "</id>\n";
                        $result .= $spaces . "  <name>" . $clm_saison->name . "</name>\n";
                        $result .= $spaces . "  <published>" . $clm_saison->published . "</published>\n";
                        $result .= $spaces . "  <archiv>" . $clm_saison->archiv . "</archiv>\n";
                        $result .= $spaces . "  <bemerkungen>" . $clm_saison->bemerkungen . "</bemerkungen>\n";
                        $result .= $spaces . "  <bem_int>" . $clm_saison->bem_int . "</bem_int>\n";
                        $result .= $spaces . "  <checked_out>" . $clm_saison->checked_out . "</checked_out>\n";
                        $result .= $spaces . "  <checked_out_time>" . $clm_saison->checked_out_time . "</checked_out_time>\n";
                        $result .= $spaces . "  <ordering>" . $clm_saison->ordering . "</ordering>\n";
                        $result .= $spaces . "  <datum>" . $clm_saison->datum . "</datum>\n";
                        $result .= $spaces . " </clm_saison>\n";
                }
                $result .= $spaces . "</clm_saisonliste>\n";

		return $result;
	}

	/**
         * get Tourney list in xml structure
         */
        public function getTourneyList($tid, $sid, $spaces) {
		$result = "";
		$query = $this->db->getQuery(true);
		$query->select('*');
		$query->from('#__clm_turniere');
		$query->order('dateStart');
		$whereClause = "";
		if ($tid != 0) {
			$whereClause = 'id=' . $tid;
			$text = "";
			$spaces = $gspaces;
		}
		if ($sid != 0) {
			if ($whereClause != "") {
				$whereClause .= ' and sid=' . $sid;
			} else {
				$whereClause = 'sid=' . $sid;
			}
		}
		if ($whereClause != "") {
			$query->where($whereClause);
		}
		$query->order("id");
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$clm_turniereliste = $this->db->loadObjectList();
		$gspaces = $spaces;
		$spaces .= " ";
		if ($tid == 0) {
			$result = $spaces . "<clm_turniereliste>\n";
		}
		foreach ($clm_turniereliste as $key => $clm_turniere) {
			$result .= $spaces . "<clm_turniere>\n";
			$result .= $spaces . " <id>" . $clm_turniere->id . "</id>\n";
			$result .= $spaces . " <name>" . $clm_turniere->name . "</name>\n";
			$result .= $spaces . " <sid>" . $clm_turniere->sid . "</sid>\n";
			$result .= $spaces . " <dateStart>" . $clm_turniere->dateStart . "</dateStart>\n";
			$result .= $spaces . " <dateEnd>" . $clm_turniere->dateEnd . "</dateEnd>\n";
			$result .= $spaces . " <catidAlltime>" . $clm_turniere->catidAlltime . "</catidAlltime>\n";
			$result .= $spaces . " <catidEdition>" . $clm_turniere->catidEdition . "</catidEdition>\n";
			$result .= $spaces . " <typ>" . $clm_turniere->typ . "</typ>\n";
			$result .= $spaces . " <tiebr1>" . $clm_turniere->tiebr1 . "</tiebr1>\n";
			$result .= $spaces . " <tiebr2>" . $clm_turniere->tiebr2 . "</tiebr2>\n";
			$result .= $spaces . " <tiebr3>" . $clm_turniere->tiebr3 . "</tiebr3>\n";
			$result .= $spaces . " <rnd>" . $clm_turniere->rnd . "</rnd>\n";
			$result .= $spaces . " <teil>" . $clm_turniere->teil . "</teil>\n";
			$result .= $spaces . " <runden>" . $clm_turniere->runden . "</runden>\n";
			$result .= $spaces . " <dg>" . $clm_turniere->dg . "</dg>\n";
			$result .= $spaces . " <tl>" . $clm_turniere->tl . "</tl>\n";
			$result .= $spaces . " <bezirk>" . $clm_turniere->bezirk . "</bezirk>\n";
			$result .= $spaces . " <bezirkTur>" . $clm_turniere->bezirkTur . "</bezirkTur>\n";
			$result .= $spaces . " <vereinZPS>" . $clm_turniere->vereinZPS . "</vereinZPS>\n";
			$result .= $spaces . " <published>" . $clm_turniere->published . "</published>\n";
			$result .= $spaces . " <started>" . $clm_turniere->started . "</started>\n";
			$result .= $spaces . " <finished>" . $clm_turniere->finished . "</finished>\n";
			$result .= $spaces . " <invitationText>" . $clm_turniere->invitationText . "</invitationText>\n";
			$result .= $spaces . " <bemerkungen>" . $clm_turniere->bemerkungen . "</bemerkungen>\n";
			$result .= $spaces . " <bem_int>" . $clm_turniere->bem_int . "</bem_int>\n";
			$result .= $spaces . " <checked_out>" . $clm_turniere->checked_out . "</checked_out>\n";
			$result .= $spaces . " <checked_out_time>" . $clm_turniere->checked_out_time . "</checked_out_time>\n";
			$result .= $spaces . " <ordering>" . $clm_turniere->ordering . "</ordering>\n";
			$result .= $spaces . " <params>" . $clm_turniere->params . "</params>\n";
			$result .= $spaces . "</clm_turniere>\n";
		}
		if ($tid == 0) {
			$result .= $spaces . "</clm_turniereliste>\n";
		}
		return $result;
	}

	public function createResultlist($tag, $result, $spaces) {
		$text = $spaces . "<result_list>\n";
		$text .= $spaces . " <result>\n";
		$text .= $spaces . "  <" . $tag . ">" . $result . "</" . $tag . ">\n";
		$text .= $spaces . " </result>\n";
		# $text .= $spaces . " <queries>\n";
		# $text .= $spaces . $this->queries;
		# $text .= $spaces . " </queries>\n";
		$text .= $spaces . "</result_list>\n";
		return $text;
	}

        public function setzeTeilnehmerStatus($teilnehmer, $status, $spaces) {
		$result = "OK: ";
		$query = $this->db->getQuery(true);
		$query->update('#__clm_turniere_tlnr');
		$query->set("tlnrStatus=" . $status);
    		$query->where("id=" . $teilnehmer);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$result .= $this->db->query();
		return $this->createResultlist("setzeTeilnehmerStatus", $result, $spaces);
	}
 
        public function loescheTische($turnier, $runde, $dg, $spaces) {
		$result = "OK: ";
		$query = $this->db->getQuery(true);
		$query->update('#__clm_turniere_rnd_termine');
		$query->set("abgeschlossen=0,tl_ok=0");
    		$query->where("nr=" . $runde . " AND dg=" . $dg . " AND turnier=" . $turnier);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$this->db->query();
		$query = $this->db->getQuery(true);
		$query->delete('#__clm_turniere_rnd_spl');
    		$query->where("runde=" . $runde . " AND turnier=" . $turnier);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$result .= $this->db->query();
		return $this->createResultlist("loescheTische", $result, $spaces);
	}
 
        public function createTisch($turnier, $runde, $dg, $brett, $snr1, $snr2, $spaces) {
		$result = "OK: ";
		if ($snr2 == 0) {
			$query = $this->db->getQuery(true);
			$query->insert('#__clm_turniere_rnd_spl');
    			$query->columns("runde, turnier, dg, brett, tln_nr, spieler, gegner, heim, pgn, ergebnis");
    			$query->values($runde . ", " . $turnier . ", " . $dg . ", " . $brett . ", " . $snr1 . ", " . $snr1 . ", " . $snr2 . ", 1, '', 5");
			$this->db->setQuery((string)$query);
			$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
			$result .= $this->db->query() . " ";
			$query = $this->db->getQuery(true);
			$query->insert('#__clm_turniere_rnd_spl');
    			$query->columns("runde, turnier, dg, brett, tln_nr, spieler, gegner, heim, pgn, ergebnis");
    			$query->values($runde . ", " . $turnier . ", " . $dg . ", " . $brett . ", " . $snr2 . ", " . $snr2 . ", " . $snr1 . ", 0, '', 4");
			$this->db->setQuery((string)$query);
			$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
			$result .= $this->db->query();
		} else {
			$query = $this->db->getQuery(true);
			$query->insert('#__clm_turniere_rnd_spl');
    			$query->columns("runde, turnier, dg, brett, tln_nr, spieler, gegner, heim, pgn");
    			$query->values($runde . ", " . $turnier . ", " . $dg . ", " . $brett . ", " . $snr1 . ", " . $snr1 . ", " . $snr2 . ", 1, ''");
			$this->db->setQuery((string)$query);
			$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
			$result .= $this->db->query() . " ";
			$query = $this->db->getQuery(true);
			$query->insert('#__clm_turniere_rnd_spl');
    			$query->columns("runde, turnier, dg, brett, tln_nr, spieler, gegner, heim, pgn");
    			$query->values($runde . ", " . $turnier . ", " . $dg . ", " . $brett . ", " . $snr2 . ", " . $snr2 . ", " . $snr1 . ", 0, ''");
			$this->db->setQuery((string)$query);
			$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
			$result .= $this->db->query();
		}
		return $this->createResultlist("createTisch", $result, $spaces);
	}
 
        public function veroeffentlicheRunde($id, $rnd, $dg, $spaces) {
		$result = "OK: ";
		$query = $this->db->getQuery(true);
		$query->update('#__clm_turniere_rnd_termine');
		$query->set("published=1,abgeschlossen=1");
    		$query->where("turnier=" . $id . " AND nr=" . $rnd . " AND dg=" .$dg);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$result .= $this->db->query();
		return $this->createResultlist("veroeffentlicheRunde", $result, $spaces);
	}
 
        public function setRunde($id, $rnd, $spaces) {
		$result = "OK: ";
		$query = $this->db->getQuery(true);
		$query->update('#__clm_turniere');
		$query->set("rnd=" . $rnd);
    		$query->where("id=" . $id);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$result .= $this->db->query();
		return $this->createResultlist("setRunde", $result, $spaces);
	}
 
        public function setGestartet($id, $spaces) {
		$result = "OK: ";
		$query = $this->db->getQuery(true);
		$query->update('#__clm_turniere');
		$query->set("started=1");
    		$query->where("id=" . $id);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$result .= $this->db->query();
		return $this->createResultlist("turnierstart", $result, $spaces);
	}
 
        public function setVeroeffentlicht($id, $spaces) {
		$result = "OK: ";
		$query = $this->db->getQuery(true);
		$query->update('#__clm_turniere');
		$query->set("published=1");
    		$query->where("id=" . $id);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$result .= $this->db->query();
		return $this->createResultlist("veroeffentlicht", $result, $spaces);
	}

	public function reallySetErgebnis($id, $r, $t1, $t2) {
		$query = $this->db->getQuery(true);
		$query->update('#__clm_turniere_rnd_spl');
		$query->set("ergebnis=" . $r . ",tiebrS=" . $t1 . ",tiebrG=" . $t2);
    		$query->where("id=" . $id);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		return $this->db->query();
	}
 
	private function getTurnierIdBySpielId($id) {
		$query = $this->db->getQuery(true);
		$query->select('turnier');
		$query->from('#__clm_turniere_rnd_spl');
		$query->where('id=' . $id);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$spiele = $this->db->loadObjectList();
		foreach ($spiele as $key => $spiel) {
			return $spiel->turnier;
		}
		return null;
	}

	private function getStartNummerBySpielId($id) {
		$query = $this->db->getQuery(true);
		$query->select('tln_nr');
		$query->from('#__clm_turniere_rnd_spl');
		$query->where('id=' . $id);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$spiele = $this->db->loadObjectList();
		foreach ($spiele as $key => $spiel) {
			return $spiel->tln_nr;
		}
		return null;
	}

	private function getStartNummerByTurnierIdUndZps($turnierId, $zps, $mgl_nr) {
		$query = $this->db->getQuery(true);
		$query->select('snr,zps,mgl_nr');
		$query->from('#__clm_turniere_tlnr');
		$query->where('turnier=' . $turnierId . ' AND zps=\'' . $zps . '\' AND mgl_nr=\'' . $mgl_nr . '\'');
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$teilnehmers = $this->db->loadObjectList();
		foreach ($teilnehmers as $key => $teilnehmer) {
			return $teilnehmer->snr;
		}
		return null;
	}

        public function setErgebnis($userType, $id1, $id2, $r1, $r2, $t1, $t2, $pin, $spaces) {
		$ok = 0;
		if ($this->allowed($userType, 2)) {
			$ok = 1;
		} else if ($this->allowed($userType, 1)) {
			$turnierId = $this->getTurnierIdBySpielId($id1);
			$zps = $this->getClmUserZps($this->clmUser);
			$mglnr = intval($this->getClmUserMglnr($this->clmUser));
			$snr = $this->getStartNummerByTurnierIdUndZps($turnierId, $zps, $mglnr);
			$startNummer1 = $this->getStartnummerBySpielId($id1);
			$startNummer2 = $this->getStartnummerBySpielId($id2);
			if (($startNummer1 == $snr) || ($startNummer2 == $snr)) {
				$ok = 1;
			}
		} else {
			// Gast muss Pin verwenden
		}
		if ($ok == 1) {
			$ret = $this->reallySetErgebnis($id1, $r1, $t1, $t2);
			$ret .= " " . $this->reallySetErgebnis($id2, $r2, $t2, $t1);
			$result = "OK: " . $ret;
		} else {
			$result = "ERROR";
		}
		# TODO - Hier muss das Ergebnis eingetragen werden
		return $this->createResultlist("ergebnismeldung", $result, $spaces);
	}
 
        /**
         * show us the result of the requested Query.
         * @return string the games to be displayed to the user
         */
        public function getMsg() {
                if (!isset($this->msg)) {
			$lang = JFactory::getLanguage();
			$lang->load('com_clm_android', JPATH_BASE . '/components/com_clm_android');
			$this->id = JRequest::getInt('id', 0);
			$this->did = JRequest::getInt('did', 0);
			$this->sid = JRequest::getInt('sid', 0);
			$this->tid = JRequest::getInt('tid', 0);
			$this->snr = JRequest::getInt('snr', 0);
			$this->snr1 = JRequest::getInt('snr1', 0);
			$this->snr2 = JRequest::getInt('snr2', 0);
			$this->r1 = JRequest::getInt('r1', 0);
			$this->r2 = JRequest::getInt('r2', 0);
			$this->pin = JRequest::getString('pin', 'nopin0');
			$this->task = JRequest::getInt('task', 0);
			$this->zps = JRequest::getString('zps', '66205');
			$this->tname = JRequest::getString('name', '');
			$this->datestart = JRequest::getString('datestart', '');
			$this->dateend = JRequest::getString('dateend', '');
			$this->ttype = JRequest::getString('type', '');
			$this->rnd = JRequest::getInt('rnd', 0);
			$this->runden = JRequest::getInt('runden', 0);
			$this->dg = JRequest::getInt('dg', 1);
			$this->brett = JRequest::getInt('brett', 1);
			$this->tie1 = JRequest::getInt('tie1', 0);
			$this->tie2 = JRequest::getInt('tie2', 0);
			$this->zps = JRequest::getString('zps', null);
			$this->teil = JRequest::getInt('teil', 20);
			$this->format = JRequest::getString('format', 'raw');
			$this->juser = JFactory::getUser();
			$this->db = JFactory::getDBO();
			$text = JText::_("COM_CLM_ANDROID_NORIGHTS");
			$this->queries = "";

			$saisonId = $this->getAktuelleSaisonId();
			$this->clmUser = $this->getClmUserId($saisonId, $this->juser->id);

			if ($this->clmUser != null) {
				$userType = $this->getClmUserType($this->clmUser);
				$userZps = $this->getClmUserZps($this->clmUser);
				$userMglnr = $this->getClmUserMglnr($this->clmUser);
				if ($this->zps == null) {
					$this->zps = $userZps;
				}
			} else {
				$userType = "guest";
				$userZps = "ZZZZZ";
				$userMglnr = "1";
			}

			// User Check
			if ($this->allowed($userType, 0)) {
				if ($this->task == 0) {
        				$text = $this->getAPI($userType, $userZps, $userMglnr, "");
				}
				if ($this->task == 1) {
       					$text = $this->getSaisonList("");
				}
				if ($this->task == 2) {
       					$text = $this->getTourneyList($this->id, $this->sid, "");
				}
				if ($this->task == 3) {
       					$text = $this->getTourneyPlayers($this->id, "");
				}
				if ($this->task == 4) {
       					$text = $this->getTourneyGames($this->id, "");
				}
				if ($this->task == 6) {
       					$text = $this->getDwzVereine($this->sid, $this->zps, "");
				}
				if ($this->task == 7) {
       					$text = $this->getRundenTermine($this->id, "");
				}
				if ($this->task == 9) {
       					$text = $this->setErgebnis($userType, $this->snr1, $this->snr2, $this->r1, $this->r2, $this->tie1, $this->tie2, $this->pin, "");
				}
			}
			if ($this->allowed($userType, 2)) {
				if ($this->task == 5) {
       					$text = $this->getDwzSpieler($this->sid, $this->zps, "");
				}
				if ($this->task == 8) {
       					$text = $this->createTournament($this->id, $this->sid, $this->tname, $this->ttype, $this->runden,
								        $this->dg, $this->datestart, $this->dateend, $this->zps, $this->teil, "");
				}
				if ($this->task == 10) {
					$text = $this->addDwzSpielerToTournament($this->did, $this->tid, "");
				}
				if ($this->task == 11) {
       					$text = $this->setGestartet($this->tid, "");
				}
				if ($this->task == 12) {
					$text = $this->setRunde($this->tid, $this->rnd, "");
				}
				if ($this->task == 13) {
       					$text = $this->setVeroeffentlicht($this->tid, "");
				}
				if ($this->task == 14) {
       					$text = $this->loescheTische($this->tid, $this->rnd, $this->dg, "");
				}
				if ($this->task == 15) {
       					$text = $this->createTisch($this->tid, $this->rnd, $this->dg, $this->brett, $this->snr1, $this->snr2, "");
				}
				if ($this->task == 16) {
       					$text = $this->veroeffentlicheRunde($this->tid, $this->rnd, $this->dg, "");
				}
				if ($this->task == 17) {
       					$text = $this->setzeTeilnehmerStatus($this->tid, $this->snr, "");
				}
			} else if ($this->allowed($userType, 1)) {
				if ($this->task == 5) {
       					$text = $this->getDwzEinzelSpieler($this->sid, $userZps, $userMglnr, "");
				}
				if ($this->task == 10) {
					$verboten = $this->holeTurnierGestartet($this->tid);
					$verboten = ($verboten || (!$this->validiereDWZSpieler($this->did, $userZps, $userMglnr)));
					if ($verboten == false) {
						$text = $this->addDwzSpielerToTournament($this->did, $this->tid, "");
					}
				}
			}

                        $this->msg = $text;
                }
                return $this->msg;
        }

	function addDwzSpielerToTournament($did, $tid, $spaces) {
		$ret = "OK";
		$ok = true;
		$query = $this->db->getQuery(true);
		$query->select('max(snr) as lastsnr, max(id) as maxid');
		$query->from('#__clm_turniere_tlnr');
		$query->where('turnier='.$tid);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$maxids = $this->db->loadObjectList();
		$lastnsr=0;
		foreach ($maxids as $key => $maxid) {
			$lastsnr = $maxid->lastsnr;
			if ($lastsnr == null) $lastsnr = 0;
		}
		$snr = $lastsnr + 1;
		$query = $this->db->getQuery(true);
		$query->select('*');
		$query->from('#__clm_dwz_spieler');
		$query->where('id = ' . $did);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$players = $this->db->loadObjectList();
		$dok = false;
		foreach ($players as $key => $player) {
			$dwzPlayer = $player;
			$dok = true;
			$sid = $player->sid;
			$name = $player->Spielername;
			$dwz = $player->DWZ;
			if ($dwz == null) {
				$dwz = 0;
			}
			$FIDE_Elo = $player->FIDE_Elo;
			$FIDE_Titel = $player->FIDE_Titel;
			$FIDE_ID = $player->FIDE_ID;
			$FIDE_Land = $player->FIDE_Land;
			$zps = $player->ZPS;
			$Mgl_Nr = $player->Mgl_Nr;
			$year = $player->Geburtsjahr;
			$Geschlecht = $player->Geschlecht;
		}

		if (!$dok) {
			$ret = "ERROR: cannot find player in DWZ list, please reload and retry";
			$ok = false;
		}

		if ($ok) {
			if ($FIDE_Elo == "") {
				$FIDE_Elo = "NULL";
			}
			if ($FIDE_ID == "") {
				$FIDE_ID = "NULL";
			}
			$cols = array('sid', 'snr', 'name', 'twz', 'start_dwz', 'FIDEelo', 'titel', 'FIDEcco', 'FIDEid', 'mgl_nr', 'zps', 'turnier', 'birthYear', 'geschlecht', 'verein', 'published');
			$values = array($sid, $snr, "'" . $name . "'", $dwz, $dwz, $FIDE_Elo, "'" . $FIDE_Titel . "'", "'" . $FIDE_Land . "'", $FIDE_ID, $Mgl_Nr, "'" . $zps . "'", $tid, "'" . $year . "'", "'" . $Geschlecht . "'", "(SELECT Vereinname FROM #__clm_dwz_vereine WHERE sid=" . $sid . " AND ZPS='" . $zps . "')" , 1);
			$query = $this->db->getQuery(true);
			$query->insert($this->db->quoteName('#__clm_turniere_tlnr'));
			$query->columns($this->db->quoteName($cols));
    			$query->values(implode(',', $values));
			$this->db->setQuery((string)$query);
			$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
			$result = $this->db->query();
			$ret = "OK: " . $result;
		}
		$this->db->setQuery("update #__clm_turniere set teil = (select count(id) from #__clm_turniere_tlnr where turnier=" . $tid .") where id=" . $tid);
		$this->queries = $this->queries . "<pre>update #__clm_turniere set teil = (select count(id) from #__clm_turniere_tlnr where turnier=" . $tid .") where id=" . $tid . "\n</pre>";
		$result = $this->db->query();
                return $this->createResultlist("addDwzSpielerToTournament", $ret, $spaces);
	}

	function holeTurnierGestartet($tid) {
		$rnd = 1;
		$started = 1;
		$query = $this->db->getQuery(true);
		$query->select('rnd,started');
		$query->from('#__clm_turniere');
		$query->where('id=' . $tid);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$tourneys = $this->db->loadObjectList();
		foreach ($tourneys as $key => $tourney) {
			$rnd = $tourney->rnd;
			$started = $tourney->started;
		}
		return (($rnd != 0) || ($started != 0));
	}

	function validiereDWZSpieler($did, $zps, $mglnr) {
		$id = -1;
		$query = $this->db->getQuery(true);
		$query->select('id');
		$query->from('#__clm_dwz_spieler');
		$query->where('id=' . $did. " AND ZPS='" . $zps . "' AND Mgl_Nr=" . $mglnr);
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$tourneys = $this->db->loadObjectList();
		foreach ($tourneys as $key => $tourney) {
			$id = $tourney->id;
		}
		return ($id != -1);
	}

	function createTournament($id, $sid, $tname, $ttype, $runden, $dg, $datestart, $dateend, $zps, $teil, $spaces) {
		$tname = urldecode($tname);
		$ret = "OK: $tname";
		$ok = true;
		$query = $this->db->getQuery(true);
		$query->select('max(id) as lastid, max(ordering) as lastorder');
		$query->from('#__clm_turniere');
		$this->db->setQuery((string)$query);
		$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
		$maxids = $this->db->loadObjectList();
		foreach ($maxids as $key => $maxid) {
			$lastid = $maxid->lastid;
			$lastorder = $maxid->lastorder;
			$lastid++;
			$lastorder++;
			if ($lastid != $id) {
				$ret = "ERROR: not matching new tournament id, please reload";
				$ok = false;
			}
		}

		$params = "optionTiebreakersFideCorrect=0";
		$params = $params . "\nuseAsTWZ=0\n";
		$params = $params . "qualiUp=0\n";
		$params = $params . "qualiUpPoss=0\n";
		$params = $params . "qualiDown=0\n";
		$params = $params . "qualiDownPoss=0\n";
		$params = $params . "addCatToName=0\n";
		$params = $params . "displayRoundDate=1\n";
		$params = $params . "displayPlayerSnr=1\n";
		$params = $params . "displayPlayerTitle=1\n";
		$params = $params . "displayPlayerClub=1\n";
		$params = $params . "displayPlayerRating=0\n";
		$params = $params . "displayPlayerElo=0\n";
		$params = $params . "displayPlayerFideLink=0\n";
		$params = $params . "displayPlayerFederation=0\n";
		$params = $params . "displayTlOK=0\n";
		$params = $params . "pgnInput=1\n";
		$params = $params . "pgnPublic=1\n";
		$params = $params . "playerViewDisplaySex=1\n";
		$params = $params . "playerViewDisplayBirthYear=1\n";
		$params = $params . "joomGalleryDisplayPlayerPhotos=0\n";
		$params = $params . "joomGalleryCatId=0\n";
		$params = $params . "joomGalleryPhotosWidth=0";

		if ($ok) {
			$cols = array('id', 'sid', 'name', 'typ', 'runden', 'dg', 'dateStart', 'dateEnd', 'ordering', 'tl', 'vereinZPS', 'teil', 'bezirk', 'bezirkTur', 'params', 'bemerkungen', 'bem_int');
			$values = array($id, $sid, "'" . $tname . "'", $ttype, $runden, $dg, "'" . $datestart . "'", "'" . $dateend . "'", $lastorder, $this->juser->id, "'" . $zps . "'", $teil, "''", "'0'", "'" . $params . "'", "''", "'erzeugt mit Android-Interface'");
			$query = $this->db->getQuery(true);
			$query->insert($this->db->quoteName('#__clm_turniere'));
			$query->columns($this->db->quoteName($cols));
    			$query->values(implode(',', $values));
			$this->db->setQuery((string)$query);
			$this->queries = $this->queries . "<pre>" . (string)$query . "\n</pre>";
			$ret = "OK: " . (string)$query;
			$this->db->query();
		}
                return $this->createResultlist("createTournament", $ret, $spaces);
	}

	function allowed($userType, $number) {
		// darf jeder (API lesen)
		if ($number == 0) return true;
		// darf jeder Spieler (eigenes Ergebnis melden)
		if ($number == 1) {
			if ($userType == "dwz") return true;
			if ($userType == "mtl") return true;
			if ($userType == "sl") return true;
			if ($userType == "sl2") return true;
			if ($userType == "mtl") return true;
			if ($userType == "mf") return true;
			if ($userType == "spl") return true;
		}
		// darf jeder Staffelleiter (Spieltag melden)
		if ($userType == "admin") return true;
		if ($userType == "dv") return true;
		if ($userType == "dv1") return true;
		if ($userType == "tsl") return true;
		if ($userType == "tl") return true;
		if ($userType == "dw") return true;
		if ($userType == "jw") return true;
		if ($userType == "vtl") return true;
		if ($userType == "vjw") return true;
		if ($userType == "vdw") return true;
		return false;
	}

        public function getQueries() {
		return $this->queries;
	}
}
?>
