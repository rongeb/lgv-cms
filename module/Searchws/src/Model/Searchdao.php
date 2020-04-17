<?php

namespace Searchws\Model;


use Application\DBConnection\ParentDao;
use ExtLib\Utils;

/**
 * Class Searchdao
 * @package Searchws\Model
 */
class Searchdao extends ParentDao
{
    /**
     * Searchdao constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $words
     * @return array
     */
    public function getPublicPages($words)
    {

        $requete = $this->dbGateway->prepare("
        
         SELECT cl.contenttitle, cl.contentsubtitle, cl.contenthtml, cl.contentcreation, cl.pagefilename, 
         cl.pagetitle, cl.sectiontitle, cl.pagerank, cl.sectionrank, cl.contentrank
          FROM
          (SELECT c.titre as contenttitle, 
          c.soustitre as contentsubtitle, c.sousrubriques_id as sectionid, c.contenuhtml as contenthtml, c.contenu_date as contentcreation,
          c.rang as contentrank, r.filename as pagefilename, r.libelle as pagetitle, r.rang as pagerank, sr.libelle as sectiontitle, sr.rang as sectionrank
          FROM contenu c
          JOIN sousrubrique sr on sr.id=c.sousrubriques_id
          JOIN rubrique r on r.id=sr.rubriques_id
          WHERE r.scope = 'public' AND r.rang >= 0 AND sr.rang >=0 AND c.rang >=0
        UNION
        SELECT l.titre as contenttitle, 
          l.soustitre as contentsubtitle, l.sousrubriques_id as sectionid, l.contenuhtml as contenthtml, l.contenu_date as contentcreation,
          l.rang as contentrank, r.filename as pagefilename, r.libelle as pagetitle, r.rang as pagerank, sr.libelle as sectiontitle, sr.rang as sectionrank
         FROM linktocontenu l
         JOIN sousrubrique sr on sr.id=l.sousrubriques_id
         JOIN rubrique r on r.id=sr.rubriques_id
         WHERE r.scope = 'public' AND r.rang >= 0 AND sr.rang >=0 AND l.rang >=0) as cl
        ORDER BY cl.pagerank, cl.sectionrank, cl.contentrank
		") or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $results = $requete->fetchAll(\PDO::FETCH_ASSOC);

        //var_dump($results);

        $utils = new Utils();
        $words = $utils->stripTags_replaceHtmlChar_trim($words, true, true, true);
        //var_dump($words);
        $arrayOfWords = explode(" ", $words);
        //var_dump($arrayOfWords);
        $matchingResults = [];
        foreach ($results as $row) {
            //var_dump($row);
            $filteredRow = $this->filterRowValues($row);
            //var_dump($filteredRow);
            $filteredRow = $this->findOccurences($arrayOfWords, $filteredRow);
            //var_dump($filteredRow);
            //var_dump(sizeof($filteredRow['occurences']));
            if (sizeof($filteredRow['occurences']) > 0) {
                array_push($matchingResults, $filteredRow);
            }
        }
        return $matchingResults;
    }

    /**
     * @param $words
     * @param $spaceid
     * @return array
     */
    public function getPrivatePages($words, $spaceid)
    {

        $requete = $this->dbGateway->prepare("
        
         SELECT cl.contenttitle, cl.contentsubtitle, cl.contenthtml, cl.contentcreation, cl.pagefilename, 
         cl.pagetitle, cl.sectiontitle, cl.pagerank, cl.sectionrank, cl.contentrank
          FROM
          (SELECT c.titre as contenttitle, 
          c.soustitre as contentsubtitle, c.sousrubriques_id as sectionid, c.contenuhtml as contenthtml, c.contenu_date as contentcreation,
          c.rang as contentrank, r.filename as pagefilename, r.libelle as pagetitle, r.rang as pagerank, sr.libelle as sectiontitle, sr.rang as sectionrank
          FROM contenu c
          JOIN sousrubrique sr on sr.id=c.sousrubriques_id
          JOIN rubrique r on r.id=sr.rubriques_id
          JOIN space s on s.space_id = r.spaceId
          WHERE r.scope = 'private' AND r.rang > 0 AND sr.rang >=0 AND c.rang >=0 AND s.space_id = :spaceid
        UNION
        SELECT l.titre as contenttitle, 
          l.soustitre as contentsubtitle, l.sousrubriques_id as sectionid, l.contenuhtml as contenthtml, l.contenu_date as contentcreation,
          l.rang as contentrank, r.filename as pagefilename, r.libelle as pagetitle, r.rang as pagerank, sr.libelle as sectiontitle, sr.rang as sectionrank
         FROM linktocontenu l
         JOIN sousrubrique sr on sr.id=l.sousrubriques_id
         JOIN rubrique r on r.id=sr.rubriques_id
         JOIN space s on s.space_id = r.spaceId
         WHERE r.scope = 'private' AND r.rang >= 0 AND sr.rang >=0 AND l.rang >=0 AND s.space_id = :spaceid) as cl
        ORDER BY cl.pagerank, cl.sectionrank, cl.contentrank
		") or die(print_r($this->dbGateway->error_info()));

        $requete->execute(
            ['spaceid' => $spaceid]
        );

        $results = $requete->fetchAll(\PDO::FETCH_ASSOC);

        $utils = new Utils();
        $words = $utils->stripTags_replaceHtmlChar_trim($words, true, true, true);
        $arrayOfWords = explode(" ", $words);
        $matchingResults = [];
        foreach ($results as $row) {
            $filteredRow = $this->filterRowValues($row);
            $filteredRow = $this->findOccurences($arrayOfWords, $filteredRow);
            if (sizeof($filteredRow['occurences']) > 0) {
                array_push($matchingResults, $filteredRow);
            }
        }
        return $matchingResults;
    }

    /**
     * @param $words
     * @return array
     */
    public function getAllPages($words, $hasContentId = false)
    {
        $contentIdGlobalSelect = '';
        $contentIdContentSelect = '';
        $linkContentLinkSelect = '';
        if($hasContentId) {
            $contentIdGlobalSelect = ', cl.linkid, cl.contentid, cl.pageid';
            $contentIdContentSelect = ' c.contenu_id as contentid, null as linkid, r.id as pageid,';
            $linkContentLinkSelect = ' l.linktocontenu_id as linkid, null as contentid, r.id as pageid,';
        }
        $requete = $this->dbGateway->prepare("
        
         SELECT cl.contenttitle, cl.contentsubtitle, cl.contenthtml, cl.contentcreation, cl.pagefilename, 
         cl.pagetitle, cl.sectiontitle, cl.pagerank, cl.pagescope, cl.sectionrank, cl.contentrank".$contentIdGlobalSelect."
          FROM
          (SELECT c.titre as contenttitle,".$contentIdContentSelect."
          c.soustitre as contentsubtitle, c.sousrubriques_id as sectionid, 
          c.contenuhtml as contenthtml, c.contenu_date as contentcreation,
          c.rang as contentrank, 
          r.filename as pagefilename, r.libelle as pagetitle, r.rang as pagerank, r.scope as pagescope,
          sr.libelle as sectiontitle, sr.rang as sectionrank
          FROM contenu c
          JOIN sousrubrique sr on sr.id=c.sousrubriques_id
          JOIN rubrique r on r.id=sr.rubriques_id
        UNION
        SELECT l.titre as contenttitle,".$linkContentLinkSelect."
          l.soustitre as contentsubtitle, l.sousrubriques_id as sectionid, 
          l.contenuhtml as contenthtml, l.contenu_date as contentcreation,
          l.rang as contentrank, r.filename as pagefilename, r.libelle as pagetitle, r.rang as pagerank, r.scope as pagescope,
          sr.libelle as sectiontitle, sr.rang as sectionrank
         FROM linktocontenu l
         JOIN sousrubrique sr on sr.id=l.sousrubriques_id
         JOIN rubrique r on r.id=sr.rubriques_id) as cl
        ORDER BY cl.pagerank, cl.sectionrank, cl.contentrank
		") or die(print_r($this->dbGateway->error_info()));

        $requete->execute();
        $results = $requete->fetchAll(\PDO::FETCH_ASSOC);

        $utils = new Utils();
        $words = $utils->stripTags_replaceHtmlChar_trim($words, true, true, true);
        $arrayOfWords = explode(" ", $words);
        $matchingResults = [];
        foreach ($results as $row) {
            $filteredRow = $this->filterRowValues($row);
            $filteredRow = $this->findOccurences($arrayOfWords, $filteredRow);
            if (sizeof($filteredRow['occurences']) > 0) {
                array_push($matchingResults, $filteredRow);
            }
        }
        return $matchingResults;
    }

    /**
     * @param $row
     * @return array
     */
    private function filterRowValues($row)
    {
        $values = [];
        $utils = new Utils();
        foreach ($row as $key => $value) {
            $values[$key] = $utils->stripTags_replaceHtmlChar_trim($value, true, true, false);
        }
        $values['occurences'] = [];
        return $values;
    }

    /**
     * @param $wordList
     * @param $row
     * @return mixed
     */
    private function findOccurences($wordList, $row)
    {
        foreach ($wordList as $word) {
            $count = 0;
            foreach ($row as $key => $value) {
                if (strcmp('sectionrank', $key) == 0 && strcmp('pagerank', $key) == 0) {
                    continue;
                }
                $word = trim($word);
                $isPresent = strpos(strtolower($value), strtolower($word));
                if ($isPresent > -1 && $count == 0) {
                    array_push($row['occurences'], $word);
                    $count++;
                }
            }
        }
        return $row;
    }
}