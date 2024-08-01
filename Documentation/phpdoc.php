<?php

/**
 * This script scans a specified directory (and its subdirectories) for PHP files,
 * extracts class documentation comments, and generates corresponding Markdown files
 * in a specified output directory. Additionally, it generates a table of contents
 * Markdown file that lists all generated class documentation files.
 *
 * Usage: php script.php -d <input directory> -o <output directory> [-t <TOC_FILENAME>]
 *
 * - `-d <input directory>`: The directory to scan for PHP files.
 * - `-o <output directory>`: The directory where the Markdown files will be saved.
 * - `-t <TOC_FILENAME>`: (Optional) The name of the table of contents Markdown file. Defaults to 'CLASSES.md'.
 */

/**
 * Reads a file and returns its content as a string.
 *
 * @param string $file Path to the file
 * @return string Content of the file
 */
function readFileContent($file)
{
    return file_get_contents($file);
}

/**
 * Extracts class documentation comments from the file content.
 *
 * @param string $content Content of the PHP file
 * @return array Extracted documentation comments
 */
function extractDocComments($content)
{
    $docComments = [
        'classes' => [],
    ];

    // Regex for class documentation
    preg_match_all('/\/\*\*(.*?)\*\/\s*class\s+(\w+)/s', $content, $classMatches, PREG_SET_ORDER);
    foreach ($classMatches as $match) {
        $docComments['classes'][] = [
            'name' => $match[2],
            'comment' => cleanDocComment($match[1]),
        ];
    }

    return $docComments;
}

/**
 * Cleans the doc comments by removing the comment asterisks and preserving line breaks.
 *
 * @param string $comment The comment to clean
 * @return string The cleaned comment
 */
function cleanDocComment($comment)
{
    $comment = preg_replace('/^[ \t]*\*[ \t]?/m', '', $comment);
    return trim($comment);
}

/**
 * Generates a markdown file from the extracted documentation comments.
 *
 * @param string $className Name of the class
 * @param array $docComments Extracted documentation comments
 * @param string $outputDir Path to the output directory
 * @return string Name of the generated markdown file
 */
function generateMarkdown($className, $docComments, $outputDir)
{
    $markdown = "# $className\n\n";

    foreach ($docComments['classes'] as $class) {
        $markdown .= "{$class['comment']}\n\n";
    }

    $fileName = "$outputDir/Classes/$className.md";
    if (!is_dir(dirname($fileName))) {
        die("The specified output directory 'Classes' does not exist.\n");
    }
    file_put_contents($fileName, $markdown);

    return $fileName;
}

/**
 * Recursively processes a directory for PHP files and generates markdown files for each found class.
 * Also creates a main markdown file with a table of contents.
 *
 * @param string $directory Path to the directory
 * @param string $outputDir Path to the output directory
 * @param string $tocFileName Name of the table of contents file
 */
function processDirectory($directory, $outputDir, $tocFileName)
{
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    $generatedFiles = [];

    foreach ($iterator as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            $content = readFileContent($file);
            $docComments = extractDocComments($content);

            if (!empty($docComments['classes'])) {
                $className = basename($file, '.php');
                $generatedFile = generateMarkdown($className, $docComments, $outputDir);
                $generatedFiles[] = $generatedFile;
            }
        }
    }

    generateTableOfContents($generatedFiles, $outputDir, $tocFileName);
}

/**
 * Generates a main markdown file with a table of contents of all generated markdown files.
 *
 * @param array $generatedFiles List of generated markdown files
 * @param string $outputDir Path to the output directory
 * @param string $tocFileName Name of the table of contents file
 */
function generateTableOfContents($generatedFiles, $outputDir, $tocFileName)
{
    $toc = "# Table of Contents\n\n";
    foreach ($generatedFiles as $file) {
        $className = basename($file, '.md');
        $toc .= "- [$className](./Classes/$className.md)\n";
    }

    file_put_contents("$outputDir/$tocFileName", $toc);
}

// Parse command line arguments
$options = getopt('d:o:t::');
if (!isset($options['d'])) {
    die("Usage: php script.php -d <directory> -o <output directory> [-t <TOC_FILENAME>]\n");
}

$directory = $options['d'];
$outputDir = isset($options['o']) ? $options['o'] : '.';
$tocFileName = isset($options['t']) ? $options['t'] : 'CLASSES.md';

if (!is_dir($directory)) {
    die("The specified directory does not exist.\n");
}

if (!is_dir($outputDir) || !is_writable($outputDir)) {
    die("The specified output directory does not exist or is not writable.\n");
}

if (!is_dir("$outputDir/Classes") || !is_writable("$outputDir/Classes")) {
    die("The specified output directory 'Classes' does not exist or is not writable.\n");
}

// Process the directory
processDirectory($directory, $outputDir, $tocFileName);
