<?php

/*
 * This file is part of the "headless" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FriendsOfTYPO3\Headless\Tests\Functional\ContentTypes;

use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;

class TextpicElementTest extends BaseContentTypeTesting
{
    public function testTextpicContentElement()
    {
        $response = $this->executeFrontendSubRequest(
            new InternalRequest('https://website.local/')
        );

        self::assertEquals(200, $response->getStatusCode());

        $fullTree = json_decode((string)$response->getBody(), true);

        $contentElement = $fullTree['content']['colPos1'][2];

        $this->checkDefaultContentFields($contentElement, 11, 1, 'textpic', 1);
        $this->checkAppearanceFields($contentElement);
        $this->checkHeaderFields($contentElement);

        // typolink parser was called on bodytext
        self::assertStringContainsString('<a href="/page1?parameter=999&amp;cHash=', $contentElement['content']['bodytext']);

        $this->checkGalleryContentFields($contentElement);
    }
}
