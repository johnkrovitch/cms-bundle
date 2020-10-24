<?php

namespace JK\CmsBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User.
 *
 * @ORM\Table(name="cms_user")
 * @ORM\Entity(repositoryClass="JK\CmsBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * User unique id.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * User name.
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="username")
     */
    protected $username;

    /**
     * User canonical name.
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="username_canonical")
     */
    protected $usernameCanonical;

    /**
     * User email.
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="email")
     */
    protected $email;

    /**
     * User canonical email.
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="email_canonical")
     */
    protected $emailCanonical;

    /**
     * User enable state.
     *
     * @var bool
     * @ORM\Column(type="boolean", name="enabled")
     */
    protected $enabled = false;

    /**
     * User password salt.
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="salt")
     */
    protected $salt;

    /**
     * User password.
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="password")
     */
    protected $password;

    /**
     * User name.
     *
     * @var DateTime
     * @ORM\Column(type="datetime", name="last_login", nullable=true)
     */
    protected $lastLogin;

    /**
     * Indicate if the user is locked.
     *
     * @var bool
     * @ORM\Column(type="boolean", name="locked")
     */
    protected $locked = false;

    /**
     * Indicate if the user is expired.
     *
     * @var bool
     * @ORM\Column(type="boolean", name="expired")
     */
    protected $expired = false;

    /**
     * User expiration date.
     *
     * @var DateTime
     * @ORM\Column(type="datetime", name="expires_at", nullable=true)
     */
    protected $expiresAt;

    /**
     * User confirmation token.
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="confirmation_token", nullable=true)
     */
    protected $confirmationToken;

    /**
     * User last password request date.
     *
     * @var DateTime
     * @ORM\Column(type="datetime", name="password_requested_at", nullable=true)
     */
    protected $passwordRequestedAt;

    /**
     * User roles.
     *
     * @var string[]
     * @ORM\Column(type="array", name="roles")
     */
    protected $roles = [];

    /**
     * Indicate if the user creadentials are expired.
     *
     * @var bool
     * @ORM\Column(type="boolean", name="credentials_expired")
     */
    protected $credentialsExpired = false;

    /**
     * User credentials expiration date.
     *
     * @var DateTime
     * @ORM\Column(type="datetime", name="credentials_expire_at", nullable=true)
     */
    protected $credentialsExpireAt;

    /**
     * @ORM\OneToMany(targetEntity="JK\CmsBundle\Entity\Article", mappedBy="author")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $articles;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="comment_last_view_date", type="datetime", nullable=true)
     */
    protected $commentLastViewDate;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="article_last_view_date", type="datetime", nullable=true)
     */
    protected $articleLastViewDate;

    /**
     * @var string
     */
    protected $profilePicture;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return string[] The user roles
     */
    public function getRoles()
    {
        $roles = [];

        foreach ($this->roles as $role) {
            $roles[] = $role;
        }

        return $roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @return string
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * @param string $usernameCanonical
     *
     * @return User
     */
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * @param string $emailCanonical
     *
     * @return User
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param DateTime $lastLogin
     *
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * @param bool $locked
     *
     * @return User
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->expired;
    }

    /**
     * @param bool $expired
     *
     * @return User
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param DateTime $expiresAt
     *
     * @return User
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * @param DateTime $passwordRequestedAt
     *
     * @return User
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * @param bool $credentialsExpired
     *
     * @return User
     */
    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * @param DateTime $credentialsExpireAt
     *
     * @return User
     */
    public function setCredentialsExpireAt($credentialsExpireAt)
    {
        $this->credentialsExpireAt = $credentialsExpireAt;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return DateTime
     */
    public function getCommentLastViewDate()
    {
        return $this->commentLastViewDate;
    }

    /**
     * @param DateTime $commentLastViewDate
     */
    public function setCommentLastViewDate($commentLastViewDate)
    {
        $this->commentLastViewDate = $commentLastViewDate;
    }

    /**
     * @return DateTime
     */
    public function getArticleLastViewDate()
    {
        return $this->articleLastViewDate;
    }

    /**
     * @param DateTime $articleLastViewDate
     */
    public function setArticleLastViewDate($articleLastViewDate)
    {
        $this->articleLastViewDate = $articleLastViewDate;
    }

    /**
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setConfirmationToken(string $confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }
}
