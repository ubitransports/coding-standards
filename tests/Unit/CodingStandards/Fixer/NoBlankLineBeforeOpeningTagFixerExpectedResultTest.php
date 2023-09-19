<?php

namespace Ubitransport\Tests\Unit\CodingStandards\Fixer;

use PhpCsFixer\Tokenizer\Tokens;
use Ubitransport\CodingStandards\Fixer\NoBlankLineBeforeOpeningTagFixer;

/**
 * Class NoBlankLineBeforeOpeningTagFixerExpectedResultTest.
 *
 * @coversDefaultClass \Ubitransport\CodingStandards\Fixer\NoBlankLineBeforeOpeningTagFixer
 */
class NoBlankLineBeforeOpeningTagFixerExpectedResultTest extends \PHPUnit_Framework_TestCase
{
    private NoBlankLineBeforeOpeningTagFixer $customFixer;

    public function setUp(): void
    {
        parent::setUp();
        $this->customFixer = new NoBlankLineBeforeOpeningTagFixer();
    }

    /**
     * @covers ::fix
     */
    public function testFix(): void
    {
        $file = new \SplFileInfo(__DIR__.'/test_cases/containsAnyCharactersBeforePhpOpeningTag.txt');
        /** @var string $fileContent */
        $fileContent = file_get_contents($file);
        $tokens = Tokens::fromCode($fileContent);
        $expectedResult = file_get_contents(__DIR__.'/test_cases/containsAnyCharactersBeforePhpOpeningTagExpectedResult.txt');

        $this->customFixer->fix($file, $tokens);

        $this->assertSame($expectedResult, $tokens->generateCode());
    }

    /**
     * @dataProvider supportsDataProvider
     *
     * @param string $filename
     * @param bool   $expected
     *
     * @covers ::supports
     */
    public function testSupports($filename, $expected): void
    {
        /** @var \SplFileInfo $splFileInfoMock */
        $splFileInfoMock = $this->mockSplFileInfoWithFilename($filename);

        $this->assertSame($expected, $this->customFixer->supports($splFileInfoMock));
    }

    /**
     * @return array<int, array<int, bool|string>>
     */
    public function supportsDataProvider()
    {
        return [
            ['test.php', true],
            ['test.html', false],
            ['test.twig', false],
            ['test.php.twig', false],
            ['test.html.twig', false],
            ['test.html.xxx', false],
            ['test.ctp', false],
        ];
    }

    /**
     * @param string $filename
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\SplFileInfo
     */
    private function mockSplFileInfoWithFilename($filename)
    {
        $fileParts = explode('.', $filename);
        $extension = strtolower(end($fileParts));
        $splFileInfoMock = $this->getMockBuilder(\SplFileInfo::class)
            ->disableOriginalConstructor()
            ->setMethods(['getFilename', 'getExtension'])
            ->getMock();
        $splFileInfoMock->expects($this->any())->method('getFilename')->willReturn($filename);
        $splFileInfoMock->expects($this->any())->method('getExtension')->willReturn($extension);

        return $splFileInfoMock;
    }
}
