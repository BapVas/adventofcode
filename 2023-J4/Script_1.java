import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Script_1 {
    public static void main(String[] args) throws IOException {
        String input = Files.readString(Path.of("data.txt"));
        String[] rows = input.split(System.lineSeparator());
        List<Integer> res = new ArrayList<>();

        for (String row : rows) {
            String[] parts = row.split(":");
            String cardName = parts[0].trim();
            String cardNumbers = parts[1].trim();

            String[] numberSets = cardNumbers.split("\\|");
            String validNumbersStr = numberSets[0].trim();
            String myNumbersStr = numberSets[1].trim();

            List<String> validNumbersMatch = new ArrayList<>();
            Matcher validNumbersMatcher = Pattern.compile("\\d+").matcher(validNumbersStr);
            while (validNumbersMatcher.find()) {
                validNumbersMatch.add(validNumbersMatcher.group());
            }

            List<String> myNumbersMatch = new ArrayList<>();
            Matcher myNumbersMatcher = Pattern.compile("\\d+").matcher(myNumbersStr);
            while (myNumbersMatcher.find()) {
                myNumbersMatch.add(myNumbersMatcher.group());
            }

            List<String> validNumbers = new ArrayList<>(myNumbersMatch);
            validNumbers.retainAll(validNumbersMatch);

            double k = 0.5;
            for (String validNumber : validNumbers) {
                k *= 2;
            }

            res.add((int) k);
        }

        int sum = res.stream().mapToInt(Integer::intValue).sum();
        System.out.println(sum);
    }
}
