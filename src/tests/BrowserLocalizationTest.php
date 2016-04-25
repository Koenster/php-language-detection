<?php namespace koenster\PHPLanguageDetection\tests;

use koenster\PHPLanguageDetection\BrowserLocalization;

class BrowserLocalizationTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var BrowserLocalization $browserLocalization
     */
    protected $browserLocalization;

    /**
     * @var array $availableLocales
     */
    protected $availableLocales;

    /**
     * @var string $defaultLocale
     */
    protected $defaultLocale;

    /**
     * @var string $browserLocalizationPreference
     */
    protected $browserLocalizationPreference = 'nl-NL,nl;q=0.9,it;q=0.7,es;q=0.5';

    /**
     * Creates a new (empty) $browserLocalization object.
     */
    protected function setUp()
    {
        $this->availableLocales = ['nl-NL', 'en-GB'];
        $this->defaultLocale = 'en-GB';
        $this->browserLocalization = new BrowserLocalization($this->defaultLocale, $this->availableLocales, $this->browserLocalizationPreference);
    }

    /**
     * Tear down test
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\setPreferences
     */
    public function testSetPreferences()
    {
        $preferencesFromBrowser = 'nl-NL,nl;q=0.9,it;q=0.7,es;q=0.5';
        $result = $this->browserLocalization->setPreferences($preferencesFromBrowser);
        $this->assertSame($preferencesFromBrowser,$result);
    }

    /**
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\setAvailable
     */
    public function testSetAvailable()
    {
        $available = ['nl-NL', 'en-GB'];
        $result = $this->browserLocalization->setAvailable($available);
        $this->assertSame($available,$result);
    }

    /**
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\setDefault
     */
    public function testSetDefault()
    {
        $default = 'en-GB';
        $result = $this->browserLocalization->setPreferences($default);
        $this->assertSame($default,$result);
    }

    /**
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\preferences
     */
    public function testPreferencesForEmptyBrowserPreference()
    {
        $preferencesFromBrowser = '';
        $result = $this->browserLocalization->preferences($preferencesFromBrowser);
        $this->assertSame(null,$result);
    }

    /**
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\preferences
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\populateBrowserPreferencesToLocales
     */
    public function testPreferencesForDetectedBrowserPreference()
    {
        $result = $this->browserLocalization->preferences($this->browserLocalizationPreference);
        $expected = ["nl-NL", "nl", "it", "es"];
        $this->assertSame($expected,$result);
    }

    /**
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\testSetLanguageForLocales
     */
    public function testSetLanguageForLocales()
    {
        $result = $this->browserLocalization->setLanguages();

        $expected = ['nl' => 'nl-NL', 'en' => 'en-GB'];

        $this->assertSame($expected,$result);
    }

    /**
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\match
     */
    public function testMatchForFoundLocale()
    {
        $this->browserLocalization->setPreferences($this->browserLocalizationPreference);
        $this->browserLocalization->preferences();
        $result = $this->browserLocalization->match();
        $this->assertSame('nl-NL',$result);
    }

    /**
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\match
     */
    public function testMatchForFoundLanguage()
    {
        $this->browserLocalization->setPreferences('nl-BE,nl;q=0.9,it;q=0.7,es;q=0.5');
        $this->browserLocalization->preferences();
        $result = $this->browserLocalization->match();
        $this->assertSame('nl-NL',$result);
    }

    /**
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\detect
     */
    public function testDetectForEmptyBrowserPreferences()
    {
        $this->browserLocalization->setPreferences('');
        $result = $this->browserLocalization->detect();
        $this->assertSame('en-GB',$result);
    }

    /**
     * @covers koenster\PHPLanguageDetection\BrowserLocalization\detect
     */
    public function testDetectForBrowserPreferences()
    {
        $this->browserLocalization->setPreferences($this->browserLocalizationPreference);
        $result = $this->browserLocalization->detect();
        $this->assertSame('nl-NL',$result);
    }
}