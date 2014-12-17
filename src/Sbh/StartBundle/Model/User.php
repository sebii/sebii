<?php

namespace Sbh\StartBundle\Model;

use Sbh\StartBundle\Model\om\BaseUser;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * 
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 * @version 1.0.0
 */
class User extends BaseUser implements AdvancedUserInterface
{
    /**
     *
     * @access protected
     * @var string
     */
    protected $plainPassword;
    
    /**
     * set plainPassword
     * 
     * Définition du plainPassword, avant l'encodage vers password
     * @access public
     * @since 1.0.0 Création -- sebii
     * @param string $plainPassword
     * @return Sbh\StartBundle\Model\User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }
    
    /**
     * get plainPassword
     * 
     * Récupération du plainPassword
     * @access public
     * @since 1.0.0 Création -- sebii
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    
    /**
     * get salt
     * 
     * Récupération du salt
     * Surcharge de la propriété de BaseUser
     * Génère un salt si inexistant
     * @access public
     * @since 1.0.0 Création -- sebii
     * @return string
     */
    public function getSalt()
    {
        $salt = $this->salt;
        if (empty($salt) || strlen($salt) === 0)
        {
            $this->generateSalt();
            $salt = $this->salt;
        }
        
        return $salt;
    }
    
    /**
     * generation du usernameCanonical
     * 
     * La fonction prend le username enregistré et en génère la forme
     * canonicale.
     * @access public
     * @since 1.0.0 Création -- sebii
     * @return Sbh\StartBundle\Model\User
     */
    public function generateUsernameCanonical()
    {
        $username          = strtolower($this->getUsername());
        $canonicalUsername = '';
        $usernameArray     = str_split($username);
        
        for ($i = 0, $iMax = count($usernameArray); $i < $iMax; $iMax++)
        {
            switch ($usernameArray[$i])
            {
                case 'a': case '@': case 'ª': case 'À': case 'Á': case 'Â':
                case 'Ã': case 'Ä': case 'Å': case 'à': case 'á': case 'â':
                case 'ã': case 'ä': case 'å': case 'Ā': case 'ā': case 'Ă':
                case 'ă': case 'Ą': case 'ą': case 'ƛ':
                    $canonicalUsername .= 'a';
                    break;
                case 'b': case 'ß': case 'ƀ': case 'Ɓ': case 'Ƃ': case 'ƃ':
                case 'Ƅ': case 'ƅ':
                    $canonicalUsername .= 'b';
                    break;
                case 'c': case 'Ç': case 'ç': case '¢': case '©': case 'Ć':
                case 'ć': case 'Ĉ': case 'ĉ': case 'Ċ': case 'ċ': case 'Č':
                case 'č': case 'Ɔ': case 'Ƈ': case 'ƈ':
                    $canonicalUsername .= 'c';
                    break;
                case 'd': case 'Ď': case 'ď': case 'Đ': case 'đ': case 'Đ':
                case 'đ': case 'Ɗ': 
                    $canonicalUsername .= 'd';
                    break;
                case 'e': case '€': case 'É': case 'È': case 'Ê': case 'Ë':
                case 'é': case 'è': case 'ê': case 'ë': case 'Ē': case 'ē':
                case 'Ĕ': case 'ĕ': case 'Ė': case 'ė': case 'Ę': case 'ę':
                case 'Ě': case 'ě': case 'Ē': case 'ē': case 'Ĕ': case 'ĕ':
                case 'Ė': case 'ė': case 'Ę': case 'ę': case 'Ě': case 'ě':
                case 'Ƌ': case 'ƌ': case 'Ǝ': case 'Ə': case 'Ɛ': case 'Ʃ':
                case 'Ƹ':
                    $canonicalUsername .= 'e';
                    break;
                case 'f': case 'ƒ': case 'Ƒ': case 'ƒ':
                    $canonicalUsername .= 'f';
                    break;
                case 'g': case 'Ĝ': case 'ĝ': case 'Ğ': case 'ğ': case 'Ġ':
                case 'ġ': case 'Ģ': case 'ģ': case 'Ĝ': case 'ĝ': case 'Ğ':
                case 'ğ': case 'Ġ': case 'ġ': case 'Ģ': case 'ģ': case 'Ɠ':
                    $canonicalUsername .= 'g';
                    break;
                case 'h': case 'Ĥ': case 'ĥ': case 'Ħ': case 'ħ': case 'Ĥ':
                case 'ĥ': case 'Ħ': case 'ħ': case 'ƕ':
                    $canonicalUsername .= 'h';
                    break;
                case 'i': case 'Ì': case 'Í': case 'Î': case 'Ï': case 'ì':
                case 'í': case 'î': case 'ï': case 'Ĩ': case 'ĩ': case 'Ī':
                case 'ī': case 'Ĭ': case 'ĭ': case 'Į': case 'į': case 'İ':
                case 'ı': case 'Ĩ': case' ĩ': case 'Ī': case 'ī': case 'Ĭ':
                case 'ĭ': case 'Į': case 'į': case 'İ': case 'ı': case 'ſ':
                case 'Ɩ': case 'Ɨ':
                    $canonicalUsername .= 'i';
                    break;
                case 'j': case 'Ĵ': case 'ĵ': case 'Ĵ': case 'ĵ':
                    $canonicalUsername .= 'j';
                    break;
                case 'k': case 'Ķ': case 'ķ': case 'ĸ': case 'Ķ': case 'ķ':
                case 'ĸ': case 'Ƙ': case 'ƙ':
                    $canonicalUsername .= 'k';
                    break;
                case 'l': case '£': case 'Ĺ': case 'ĺ': case 'Ļ': case 'ļ':
                case 'Ľ': case 'ľ': case 'Ŀ': case 'ŀ': case 'Ł': case 'ł':
                case 'Ĺ': case 'ĺ': case 'Ļ': case 'ļ': case 'Ľ': case 'ľ':
                case 'Ŀ': case 'ŀ': case 'Ł': case 'ł': case 'ƚ': case 'ƪ':
                    $canonicalUsername .= 'l';
                    break;
                case 'm':
                    $canonicalUsername .= 'm';
                    break;
                case 'n': case 'Ñ': case 'ñ': case 'Ń': case 'ń': case 'Ņ':
                case 'ņ': case 'Ň': case 'ň': case 'ŉ': case 'Ŋ': case 'ŋ':
                case 'Ń': case 'ń': case 'Ņ': case 'ņ': case 'Ň': case 'ň':
                case 'ŉ': case 'Ŋ': case 'ŋ': case 'Ɲ': case 'ƞ': case 'ƿ':
                    $canonicalUsername .= 'n';
                    break;
                case 'o': case 'Ò': case 'Ó': case 'Ô': case 'Õ': case 'Ö':
                case 'Ø': case 'ð': case 'ò': case 'ó': case 'ô': case 'õ':
                case 'ö': case 'ø': case '¤': case 'Ō': case 'ō': case 'Ŏ':
                case 'ŏ': case 'Ő': case 'ő': case 'Ɵ': case 'Ơ': case 'ơ':
                    $canonicalUsername .= 'o';
                    break;
                case 'p': case 'Þ': case 'þ': case 'Ƥ': case 'ƥ':
                    $canonicalUsername .= 'p';
                    break;
                case 'q': case 'Ƣ': case 'ƣ':
                    $canonicalUsername .= 'q';
                    break;
                case 'r': case '®': case 'Ŕ': case 'ŕ': case 'Ŗ': case 'ŗ':
                case 'Ř': case 'ř': case 'Ʀ':
                    $canonicalUsername .= 'r';
                    break;
                case 's': case 'Š': case '$': case '§': case 'Ś': case 'ś':
                case 'Ŝ': case 'ŝ': case 'Ş': case 'ş': case 'Š': case 'š':
                case 'Ƨ': case 'ƨ':
                    $canonicalUsername .= 's';
                    break;
                case 't': case '†': case '‡': case 'Ţ': case 'ţ': case 'Ť':
                case 'ť': case 'Ŧ': case 'ŧ': case 'ƫ': case 'Ƭ': case 'ƭ':
                case 'Ʈ': case 'ǂ':
                    $canonicalUsername .= 't';
                    break;
                case 'u': case 'Ù': case 'Ú': case 'Û': case 'Ü': case 'ù':
                case 'ú': case 'û': case 'ü': case 'Ũ': case 'ũ': case 'Ū':
                case 'ū': case 'Ŭ': case 'ŭ': case 'Ů': case 'ů': case 'Ű':
                case 'ű': case 'Ų': case 'ų': case 'Ư': case 'ư': case 'Ʊ':
                    $canonicalUsername .= 'u';
                    break;
                case 'v': case 'Ʋ':
                    $canonicalUsername .= 'v';
                    break;
                case 'w': case 'Ŵ': case 'ŵ': case 'Ɯ':
                    $canonicalUsername .= 'w';
                    break;
                case 'x': case '×':
                    $canonicalUsername .= 'x';
                    break;
                case 'y': case 'Ÿ': case '¥': case 'Ý': case 'ý': case 'ÿ':
                case 'ŷ': case 'Ÿ': case 'Ɣ': case 'Ƴ': case 'ƴ':
                    $canonicalUsername .= 'y';
                    break;
                case 'z': case 'Ž': case 'ž': case 'Ź': case 'ź': case 'Ż':
                case 'ż': case 'Ƶ': case 'ƶ':
                    $canonicalUsername .= 'z';
                    break;
                case 'Æ': case 'æ':
                    $canonicalUsername .= 'ae';
                    break;
                case 'Ĳ': case 'ĳ':
                    $canonicalUsername .= 'ij';
                    break;
                case 'Œ': case 'œ':
                    $canonicalUsername .= 'oe';
                    break;
                case '™':
                    $canonicalUsername .= 'tm';
                    break;
                case '0':
                    $canonicalUsername .= '0';
                    break;
                case '1': case '¹': case 'ǀ':
                    $canonicalUsername .= '1';
                    break;
                case '2': case '²': case 'ƻ': case 'ǁ':
                    $canonicalUsername .= '2';
                    break;
                case '3': case '³': case 'Ʒ': case 'ƺ':
                    $canonicalUsername .= '3';
                    break;
                case '4':
                    $canonicalUsername .= '4';
                    break;
                case '5': case 'Ƽ': case 'ƽ': case 'ƾ':
                    $canonicalUsername .= '5';
                    break;
                case '6':
                    $canonicalUsername .= '6';
                    break;
                case '7':
                    $canonicalUsername .= '7';
                    break;
                case '8':
                    $canonicalUsername .= '8';
                    break;
                case '9':
                    $canonicalUsername .= '9';
                    break;
                case '½':
                    $canonicalUsername .= '1-2';
                    break;
                case '¼':
                    $canonicalUsername .= '1-4';
                    break;
                case '¾':
                    $canonicalUsername .= '3-4';
                    break;
                default:
                    if (strlen($canonicalUsername) == 0 || substr($canonicalUsername, -1, 1) != '-')
                    {
                        $canonicalUsername .= '-';
                    }
            }
            
            $canonicalUsername = trim($canonicalUsername, '-');
            $this->setUsernameCanonical($canonicalUsername);
            
            return $this;
        }
    }
    
    /**
     * generation du salt
     * 
     * Génération du grain de sel (salt) pour le mot de passe.
     * @access public
     * @since 1.0.0 Création -- sebii
     * @return Sbh\StartBundle\Model\User
     */
    public function generateSalt()
    {
        $salt       = '';
        $choooseIn  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $saltLength = 15;
        $choooseInLenght = strlen($choooseIn);
        for ($i = 0; $i < $saltLength; $i++)
        {
            $salt .= $choooseIn[rand(0, $choooseInLenght - 1)];
        }
        $this->setSalt($salt);
        
        return $this;
    }
    
    /**
     * Ajouter un role
     * 
     * Ajouter un role à l'utilisateur
     * @since 1.0.0 Création -- sebii
     * @access public
     * @param string $role
     * @return Sbh\StartBundle\Model\User
     */
    public function addRole($role)
    {
        $role  = trim($role);
        $roles = $this->getRoles();
        if (!empty($role) && !in_array($role, $roles))
        {
            $roles[] = $role;
            $this->setRoles($roles);
        }
        
        return $this;
    }
    
    /**
     * Supprimer un role
     * 
     * Supprimer un role à l'utilisateur
     * @since 1.0.0 Création -- sebii
     * @access public
     * @param string $role
     * @return Sbh\StartBundle\Model\User
     */
    public function removeRole($role)
    {
        $role  = trim($role);
        $roles = $this->getRoles();
        
        if (!empty($role) && in_array($role, $roles))
        {
            for ($i = 0, $key = null; isset($roles[$i]); $i++)
            {
                if ($roles[$i] == $role)
                {
                    $key = $i;
                    break;
                }
            }
            if ($key !== null)
            {
                array_splice($roles, $key, 1);
            }
            $this->setRoles($roles);
        }
        
        return $this;
    }
    
    /**
     * a le role ?
     * 
     * Vérifie si l'utilisateur possède le role demandé
     * @since 1.0.0 Création -- sebii
     * @access public
     * @param string $role
     * @return boolean
     */
    public function hasRole($role)
    {
        $hasRole = in_array($role, $this->getRoles());
        
        return $hasRole;
    }
    
    /**
     * generation de l'activationKey
     * 
     * Génération de la clef d'activation du compte
     * @since 1.0.0 Création -- sebii
     * @access public
     * @return Sbh\StartBundle\Model\User
     */
    public function generateActivationKey()
    {
        $activationKey = '';
        $choooseIn     = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $keyLength     = 30;
        $choooseInLenght = strlen($choooseIn);
        for ($i = 0; $i < $keyLength; $i++)
        {
            $activationKey .= $choooseIn[rand(0, $choooseInLenght - 1)];
        }
        $this->setActivationKey($activationKey);
        
        return $this;
    }
    
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @return void
     */
    public function eraseCredentials()
    {
        
    }
    
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @return boolean
     */
    public function isAccountNonExpired()
    {
        return true;
    }
    
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @return boolean
     */
    public function isAccountNonLocked()
    {
        $isDelete    = $this->getIsDelete();
        
        $isNonLocked = !$isDelete;
        
        return $isNonLocked;
    }
    
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @return boolean
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }
    
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @return boolean
     */
    public function isEnabled()
    {
        $isActive  = $this->getIsActive();
        
        $isEnabled = $isActive;
        
        return $isEnabled;
    }
        
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @return Sbh\StartBundle\Model\User
     */
    public function operationsAfterForm()
    {
        $this
            ->setUsername(trim($this->getUsername()))
            ->generateUsernameCanonical()
            ->generateSalt()
            ->generateActivationKey()
            ->setOrigin(UserPeer::ORIGIN_ADMIN)
            ->setIsActive(true);
        return $this;
    }
    
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @param string $password
     * @return boolean
     */
    public function createAfterForm($password)
    {
        $this
            ->setPassword($password)
            ->addRole('ROLE_USER');
        try
        {
            $this->save();
            $isUserCreated = true;
        }
        catch (PropelException $e)
        {
            $isUserCreated = false;
        }
        return $isUserCreated;
    }
    
//    /**
//     * 
//     * @since 1.0.0 Création -- sebii
//     * @access public
//     * @param iiTools\StartBundle\Model\Site $site
//     * @return boolean
//     */
//    public function isAdminSite(Site $site)
//    {
//        $isAdminSite = false;
//        foreach ($this->getUserAdminSitesRelatedByUserId() as $userAdminSite)
//        {
//            if ($userAdminSite->getSite() == $site)
//            {
//                $isAdminSite = true;
//            }
//        }
//        return $isAdminSite;
//    }
}
