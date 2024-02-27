<?php
namespace App\Form\DataModel;

use App\Config\DefaultTextConfig;
use Symfony\Component\Validator\Constraints as Assert;

class PostuloModel
{
    public const LOCALISATION_AIX = 'localisation_aix';

    public const LOCALISATION_PELISSANNE = 'localisation_pelissanne';

    public const SEARCH_ALTERNANCE = 'search_alternance';

    public const SEARCH_CDI = 'search_cdi';


    #[Assert\Choice(choices: [self::LOCALISATION_AIX, self::LOCALISATION_PELISSANNE], message: 'Choisissez une localisation')]
    private ?string $localisation = self::LOCALISATION_AIX;

    #[Assert\Choice(choices: [self::SEARCH_ALTERNANCE, self::SEARCH_CDI], message: 'Choisissez un type de contrat recherché')]
    private ?string $search = self::SEARCH_ALTERNANCE;

    #[Assert\Length(max: 300, maxMessage: '300 caractères maximum')]
    private ?string $emailContentEnterpriseParaph = null;
    
    #[Assert\Email(message: 'Adresse email invalide')]
    #[Assert\Length(max: 200, maxMessage: '200 caractères maximum')]
    #[Assert\NotBlank(message: 'L\'adresse email de l\'entreprise est obligatoire')]
    private ?string $enterpriseEmail = null;

    #[Assert\Length(max: 200, maxMessage: '200 caractères maximum')]
    #[Assert\NotBlank(message: 'Le nom de l\'entreprise est obligatoire')]
    private ?string $enterpriseName = null;

    #[Assert\Length(max: 200, maxMessage: '200 caractères maximum')]
    private ?string $enterpriseCity = null;

    #[Assert\NotBlank(message: 'Le paragraphe sur l\'entreprise est obligatoire')]
    #[Assert\Length(max: 300, maxMessage: '300 caractères maximum')]
    private ?string $motivationLetterEnterpriseParaph = DefaultTextConfig::MOTIVATION_LETTER_ENTERPRISE_PARAPH;

    /**
     * Get the value of motivationLetterEnterpriseParaph
     */ 
    public function getMotivationLetterEnterpriseParaph()
    {
        return $this->motivationLetterEnterpriseParaph;
    }

    /**
     * Set the value of motivationLetterEnterpriseParaph
     *
     * @return  self
     */ 
    public function setMotivationLetterEnterpriseParaph($motivationLetterEnterpriseParaph)
    {
        $this->motivationLetterEnterpriseParaph = $motivationLetterEnterpriseParaph;

        return $this;
    }

    /**
     * Get the value of enterpriseName
     */ 
    public function getEnterpriseName()
    {
        return $this->enterpriseName;
    }

    /**
     * Set the value of enterpriseName
     *
     * @return  self
     */ 
    public function setEnterpriseName($enterpriseName)
    {
        $this->enterpriseName = $enterpriseName;

        return $this;
    }

    /**
     * Get the value of enterpriseEmail
     */ 
    public function getEnterpriseEmail()
    {
        return $this->enterpriseEmail;
    }

    /**
     * Set the value of enterpriseEmail
     *
     * @return  self
     */ 
    public function setEnterpriseEmail($enterpriseEmail)
    {
        $this->enterpriseEmail = $enterpriseEmail;

        return $this;
    }

    /**
     * Get the value of search
     */ 
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * Set the value of search
     *
     * @return  self
     */ 
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get the value of localisation
     */ 
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set the value of localisation
     *
     * @return  self
     */ 
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get the value of emailContentEnterpriseParaph
     */ 
    public function getEmailContentEnterpriseParaph()
    {
        return $this->emailContentEnterpriseParaph;
    }

    /**
     * Set the value of emailContentEnterpriseParaph
     *
     * @return  self
     */ 
    public function setEmailContentEnterpriseParaph($emailContentEnterpriseParaph)
    {
        $this->emailContentEnterpriseParaph = $emailContentEnterpriseParaph;

        return $this;
    }

    /**
     * Get the value of enterpriseCity
     */ 
    public function getEnterpriseCity()
    {
        return $this->enterpriseCity;
    }

    /**
     * Set the value of enterpriseCity
     *
     * @return  self
     */ 
    public function setEnterpriseCity($enterpriseCity)
    {
        $this->enterpriseCity = $enterpriseCity;

        return $this;
    }
}