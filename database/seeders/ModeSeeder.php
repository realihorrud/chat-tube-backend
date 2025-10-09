<?php

declare(strict_types=1);

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

final class ModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modes')->truncate();
        DB::table('modes')->insert([
            [
                'key' => 'short',
                'label' => 'Super short',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Summarize the following text into 1–2 sentences.  
                    At the end, add a section starting with "👉 Short:" followed by the summary.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'concise',
                'label' => 'Concise way',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Read the following text and summarize it in a clear and concise way (3-6 sentences max).  
                    Do not add explanations or extra details.  
                    At the end, write the summary starting with "👉 Short:".
                    Transcript:
                EOF,
            ],
            [
                'key' => 'political',
                'label' => 'Political & News',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Summarize this political news video in a concise, factual way without opinion, bias, or emotional 
                    language. Focus only on who, what, when, where, and why. Keep the summary short enough to be read in under 30 seconds.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'tech',
                'label' => 'Tech Tutorials / How-To Videos',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Extract all actionable steps in the order they appear, skip filler and personal anecdotes, and keep
                    the language clear and concise.
                    Include timestamps for each major step.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'news',
                'label' => 'News & Current Events',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Summarize the key facts in chronological order, highlight any verified sources or data, and keep the
                    tone neutral. End with a single-sentence overall takeaway.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'education',
                'label' => 'Educational / Explainers (Science, History, etc.)',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Provide a concise overview of the main concepts, definitions, and examples. Organize the summary 
                    into short paragraphs for each key topic. Avoid jargon unless explained.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'reviews',
                'label' => 'Reviews (Products, Movies, Games)',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    List the main pros and cons mentioned, summarize the reviewer’s final verdict, and note any standout
                    quotes or moments. Keep under 150 words.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'commentary',
                'label' => 'Commentary / Opinion Pieces',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Summarize the speaker’s main argument, supporting points, and any counterarguments they mention. 
                    Use a neutral tone, even if the video isn’t.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'podcasts',
                'label' => 'Podcasts / Interviews',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    List the main topics discussed, who said them, and any key quotes. Include timestamps for topic
                    changes and avoid summarizing small talk.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'documentaries',
                'label' => 'Documentaries',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Highlight the major sections or chapters of the video, summarize each briefly, and note important 
                    statistics or events. Keep the tone informative, not dramatic.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'entertainment',
                'label' => 'Entertainment Recaps (TV Shows, Movies)',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Give a spoiler-labeled plot summary, key moments, and character developments. 
                    Keep it engaging but avoid unnecessary detail.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'motivational',
                'label' => 'Motivational / Self-Help',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Extract the core advice, any frameworks or methods described, and summarize any illustrative 
                    stories briefly. End with the central motivational message.
                    Transcript:
                EOF,
            ],
            [
                'key' => 'drama',
                'label' => 'Drama / Gossip Content',
                'value' => <<<'EOF'
                    Detect the language of the transcript and respond in that language
                    Summarize the events, who is involved, and the timeline. Keep it factual but include notable quotes 
                    or key dramatic moments that drive the story.
                    Transcript:
                EOF,
            ],
        ]);
    }
}
