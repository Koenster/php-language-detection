<?php namespace koenster\PHPLanguageDetection;

use koenster\PHPLanguageDetection\contract\LocalizationContract;

class BrowserLocalization implements LocalizationContract
{

    const LOCALE_PATTERN = '/^[a-z]{2}-[A-Z]{2}/';

    /**
     * @var string The default locale/language
     */
    protected $default = 'nl-NL';

    /**
     * @var array The available locales/languages
     */
    protected $available = ['nl-NL'];

    /**
     * @var null The preference from the browser in a string
     */
    protected $browserPreferences = null;

    /**
     * @var array The preference from the browser per language/locale
     */
    protected $preferences = [];

    /**
     * El constructor
     *
     * @author Koen Blokland
     *
     * @param string $locale
     * @param array $locales
     * @param string $browserPreference
     */
    public function __construct($locale = 'en-GB', array $locales = ['en-GB'], $browserPreference = '')
    {
        $this->default = $locale;
        $this->available = $locales;
        $this->browserPreference = $browserPreference;

        return $this;
    }

    /**
     * Setting the browser preferences
     *
     * {@inheritdoc}
     */
    public function setAvailable(array $available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Setting the browser preferences
     *
     * {@inheritdoc}
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Setting the browser preferences
     *
     * {@inheritdoc}
     */
    public function setPreferences($preferences)
    {
        $this->browserPreferences = $preferences;

        return $this;
    }

    /**
     * Detect from browser settings by first populating preferences and than match them to the available given settings
     *
     * {@inheritdoc}
     */
    public function detect()
    {
        if ($this->browserPreferences) {

            $this->preferences();

            $matched = $this->match();

            if ($matched) {
                return $matched;
            } else {
                return $this->default;
            }

        } else {
            return $this->default;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preferences($preferences = null)
    {

        if ($preferences !== null) {
            $this->browserPreference = $preferences;
        }

        $browserPreferences = explode(",", $this->browserPreference);

        if (isset($browserPreferences[0]) && strlen($browserPreferences[0]) >= 2) {

            return $this->preferences = $this->populateBrowserPreferencesToLocales($browserPreferences);

        } else {
            return null;
        }

    }

    /**
     * Match the found languages/locales to the provided avilable locales/languages
     *
     * {@inheritdoc}
     */
    public function match()
    {
        $languages = $this->setLanguages();

        foreach ($this->preferences as $preference) {
            if (preg_match(self::LOCALE_PATTERN, $preference) && in_array($preference, $this->available)) {
                return $this->available[array_search($preference, $this->available)];
            } elseif (isset($languages[$preference])) {
                return $languages[$preference];
            }
        }

        return null;
    }

    /**
     * Will populate the languages
     *
     * @author Koen Blokland Visser
     *
     * @return array Languages
     */
    public function setLanguages()
    {
        $languages = [];
        foreach ($this->available as $locale) {
            $languages[substr($locale, 0, 2)] = $locale;
        }

        return $languages;
    }

    /**
     * Populates the locales. When a full locale is found, map it! If not, than map the language. In browser language the first 2 characters of the found preferences is the language
     *
     * @author Koen Blokland Visser
     *
     * @param array $preferences
     *
     * @return array
     */
    private function populateBrowserPreferencesToLocales(array $preferences)
    {
        $locales = [];
        foreach ($preferences as $preference) {
            if (preg_match(self::LOCALE_PATTERN, $preference)) {
                $locales[] = $preference;
            } else {
                $locales[] = substr($preference, 0, 2);
            }
        }

        return $locales;
    }
}

